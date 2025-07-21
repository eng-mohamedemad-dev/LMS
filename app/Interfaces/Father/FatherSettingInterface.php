<?php

namespace App\Interfaces\Father;

interface FatherSettingInterface
{
    public function all();
    public function update($id, array $data);
    public function approve($id);
}
