<?php

namespace App\Interfaces;

interface FileInterface
{
    public function create(array $data);
    public function delete($id);
}
