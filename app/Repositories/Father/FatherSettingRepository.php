<?php

namespace App\Repositories\Father;

use App\Interfaces\Father\FatherSettingInterface;
use App\Models\Father;

class FatherSettingRepository implements FatherSettingInterface
{
    public function all() {
        return Father::with(['students','students.classroom'])->get();
    }
    public function update($father, array $data)
    {
        $father->load(['students','students.classroom']);
        return tap($father,function($father) use ($data){
            return $father->update($data);
        });
    }

    public function approve($id)
    {
        $father = Father::findOrFail($id);
        if ($father->status === 'approved') {
            return false;
        }
        $father->load(['students','students.classroom']);
        return tap($father,function($father) {
            return $father->update([
                    'status' => 'approved'
            ]);
        });
    }

}
