<?php

namespace App\Providers;

use App\Models\File;
use App\Models\Subject;
use Google\Service\Drive;
use App\Policies\FilePolicy;
use Laravel\Sanctum\Sanctum;
use App\Policies\SubjectPolicy;
use App\Interfaces\FileInterface;
use App\Interfaces\QuizInterface;
use App\Interfaces\VideoInterface;
use App\Interfaces\LessonInterface;
use App\Interfaces\SubjectInterface;
use App\Repositories\FileRepository;
use App\Repositories\QuizRepository;
use Illuminate\Support\Facades\Gate;
use App\Interfaces\QuestionInterface;
use App\Repositories\VideoRepository;
use App\Interfaces\ClassroomInterface;
use App\Repositories\LessonRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use App\Repositories\QuestionRepository;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use App\Repositories\ClassroomRepository;
use App\Interfaces\StudentQuizResultInterface;
use App\Repositories\Student\StudentQuizResultRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClassroomInterface::class,ClassroomRepository::class);
        $this->app->bind(\App\Interfaces\Teacher\TeacherSettingInterface::class, \App\Repositories\Teacher\TeacherSettingRepository::class);
        $this->app->bind(\App\Interfaces\Teacher\TeacherProfileInterface::class, \App\Repositories\Teacher\TeacherProfileRepository::class);
        $this->app->bind(\App\Interfaces\Student\StudentSettingInterface::class, \App\Repositories\Student\StudentSettingRepository::class);
        $this->app->bind(\App\Interfaces\Student\StudentProfileInterface::class, \App\Repositories\Student\StudentProfileRepository::class);
        $this->app->bind(\App\Interfaces\Father\FatherSettingInterface::class, \App\Repositories\Father\FatherSettingRepository::class);
        $this->app->bind(\App\Interfaces\Father\FatherProfileInterface::class, \App\Repositories\Father\FatherProfileRepository::class);
        $this->app->bind(\App\Interfaces\Admin\AdminProfileInterface::class, \App\Repositories\Admin\AdminProfileRepository::class);
        $this->app->bind(LessonInterface::class,LessonRepository::class);
        $this->app->bind(SubjectInterface::class,SubjectRepository::class);
        $this->app->bind(QuizInterface::class,QuizRepository::class);
        $this->app->bind(QuestionInterface::class,QuestionRepository::class);
        $this->app->bind(FileInterface::class,FileRepository::class);
        $this->app->bind(VideoInterface::class,VideoRepository::class);
        $this->app->bind(StudentQuizResultInterface::class,StudentQuizResultRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         try {
            Storage::extend('google', function($app, $config) {
                $options = [];
                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }
                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }
                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
                $service = new Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch(\Exception $e) {
           info($e->getMessage());
        }

        Gate::before(function ($user, $ability) {
        if ($user->hasRole('admin')) {
            return true;
        }
        });
        $permission = Permission::get()->pluck('name')->toArray();
        if ($permission) {
            foreach($permission as $value) {
                Gate::define($value,function($user) use ($value) {
                    return $user->hasPermissionTo($value);
                });
            }
            Gate::policy(File::class,FilePolicy::class);
        }
            Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
