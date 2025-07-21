<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        $lessons = $user->subject->lessons->pluck('id')->toArray();
        return in_array(request()->input('lesson_id'),$lessons) ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, File $file): bool
    {
       $lessons = $user->subject->lessons->pluck('id')->toArray();
      return in_array($file->lesson_id,$lessons) ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user, File $file): bool
    {
        return false;
    }
}
