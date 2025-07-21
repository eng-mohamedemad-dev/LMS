<?php

namespace App\Repositories;

use App\Interfaces\FileInterface;
use App\Models\File;

class FileRepository implements FileInterface
{
   
    public function create(array $data)
    {
        return File::create($data);
    }

    public function delete($file)
    {
        return $file->delete();
    }
}
