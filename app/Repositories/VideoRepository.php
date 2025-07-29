<?php

namespace App\Repositories;

use App\Interfaces\VideoInterface;
use App\Models\Video;

class VideoRepository implements VideoInterface
{
    public function all()
    {
        return Video::all();
    }

    public function find($id)
    {
        return Video::findOrFail($id);
    }

    public function create(array $data)
    {
        return Video::create($data);
    }

    public function update($id, array $data)
    {
        $video = Video::findOrFail($id);
        $video->update($data);
        return $video;
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        return $video->delete();
    }
}
