<?php

namespace App\Interfaces\Father;

interface FatherProfileInterface
{
    public function show($father);

    public function update($father, array $data);

    public function delete($father);
}
