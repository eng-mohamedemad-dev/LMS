<?php

namespace App\Interfaces\Admin;

interface AdminProfileInterface
{
    public function show($admin);

    public function update($admin, array $data);

    public function delete($admin);
}
