<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class StudentNotificationController extends Controller
{
    public $user;
    public function __construct() {
        $this->user = auth('student')->user();
    }
    public function index() {
        $notifications = $this->user->notifications()->get();
        return self::success('جميع الإشعارات',NotificationResource::collection($notifications));
    }

    public function markAsRead($id) {
        $notification = $this->user->notifications()->findOrFail($id);
        $notification->markAsRead();
        return self::success('تم تحديث الإشعار بنجاح',new NotificationResource($notification));
    }

    public function markAllAsRead() {
        $this->user->unreadNotifications()->update(['read_at' => now()]);
        return self::success('تم تحديث جميع الإشعارات بنجاح',NotificationResource::collection($this->user->notifications()->get()));
    }
   
    
    public function unreadNotificationsCount() {
        $unreadNotificationsCount = $this->user->unreadNotifications()->count();
        return self::success('عدد الإشعارات الغير مقروءة', $unreadNotificationsCount);
    }

    public function delete($id) {
        $notification = $this->user->notifications()->findOrFail($id);
        $notification->delete();
        return self::success('تم حذف الإشعار بنجاح');
    }

    public function deleteAll() {
        $this->user->notifications()->delete();
        return self::success('تم حذف جميع الإشعارات بنجاح');
    }
}
