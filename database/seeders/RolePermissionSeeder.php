<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'student']);
        $fatherRole = Role::firstOrCreate(['name' => 'father', 'guard_name' => 'father']);

        // مثال على بعض الصلاحيات الأساسية
        $permissions = [
            // صلاحيات عامة
            ['name' => 'manage users', 'guard_name' => 'admin'],
            ['name' => 'manage teachers', 'guard_name' => 'admin'],
            ['name' => 'manage students', 'guard_name' => 'admin'],
            ['name' => 'manage fathers', 'guard_name' => 'admin'],
            ['name' => 'manage classrooms', 'guard_name' => 'admin'],
            // صلاحيات المعلم
            ['name' => 'upload lesson', 'guard_name' => 'teacher'],
            ['name' => 'create quiz', 'guard_name' => 'teacher'],
            ['name' => 'manage subject', 'guard_name' => 'teacher'],
            // صلاحيات الطالب
            ['name' => 'take quiz', 'guard_name' => 'student'],
            ['name' => 'view lessons', 'guard_name' => 'student'],
            // صلاحيات ولي الأمر
            ['name' => 'view children progress', 'guard_name' => 'father'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate($perm);
        }

        // ربط الصلاحيات بالأدوار
        $adminRole->givePermissionTo(Permission::where('guard_name', 'admin')->pluck('name')->toArray());
        $teacherRole->givePermissionTo(Permission::where('guard_name', 'teacher')->pluck('name')->toArray());
        $studentRole->givePermissionTo(Permission::where('guard_name', 'student')->pluck('name')->toArray());
        $fatherRole->givePermissionTo(Permission::where('guard_name', 'father')->pluck('name')->toArray());

    }
}
