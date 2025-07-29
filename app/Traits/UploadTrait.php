<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    static function upload($drive,$directory,$file) {
        return Storage::disk($drive)->putFile($directory, $file);
    }

    static function deleteFile($drive,$file) {
        return Storage::disk($drive)->delete($file);
    }
}
