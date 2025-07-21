<?php

namespace App\Interfaces;

interface ClassroomInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
}
