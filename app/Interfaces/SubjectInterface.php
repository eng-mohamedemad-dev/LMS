<?php

namespace App\Interfaces;

interface SubjectInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
}
