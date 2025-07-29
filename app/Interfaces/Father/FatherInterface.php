<?php

namespace App\Interfaces\Father;

interface FatherInterface
{
    public function login(array $credentials);
    public function register(array $data);
}
