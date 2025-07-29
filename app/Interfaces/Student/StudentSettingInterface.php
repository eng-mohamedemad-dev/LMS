<?php

namespace App\Interfaces\Student;

interface StudentSettingInterface
{
    public function all() ;
    public function update($id, array $data);
    public function approve($id);
}
