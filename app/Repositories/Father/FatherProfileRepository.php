<?php

namespace App\Repositories\Father;

use Illuminate\Support\Facades\Storage;
use App\Interfaces\Father\FatherProfileInterface;
use Illuminate\Support\Facades\Hash;

class FatherProfileRepository implements FatherProfileInterface
{
    public function show($father)
    {
        return $father->load(['students', 'students.classroom']);
    }

    public function update($father, array $data)
    {
        if (isset($data['current_password'])) {
        if (!Hash::check($data['current_password'], $father->password)) {
            return false;
        } 
        }
        return tap($father, function ($father) use ($data) {
            $father->update($data);
        });
    }

    public function delete($father)
    {
        Storage::disk('public')->delete($father->image);
        return $father->delete();
    }
}
