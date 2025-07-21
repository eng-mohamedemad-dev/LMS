<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Facades\Storage;
use App\Interfaces\Admin\AdminProfileInterface;
use Illuminate\Support\Facades\Hash;

class AdminProfileRepository implements AdminProfileInterface
{
    public function show($admin)
    {
        return $admin;
    }

    public function update($admin, array $data)
    {
        if (isset($data['current_password'])) {
            if (!Hash::check($data['current_password'], $admin->password)) {
                return false;
            } 
        }
        return tap($admin, function ($admin) use ($data) {
            $admin->update($data);
        });
    }

    public function delete($admin)
    {
        Storage::disk('public')->delete($admin->image);
        return $admin->delete();
    }
}
