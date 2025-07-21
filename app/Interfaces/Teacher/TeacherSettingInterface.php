<?php

namespace App\Interfaces\Teacher;

interface TeacherSettingInterface
{
    /**
     * تحديث بيانات المدرس
     */
    public function update($teacher, array $data);

    public function approve($teacher);

    public function all();
}
