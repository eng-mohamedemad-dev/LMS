<?php

namespace App\Services;

use App\Interfaces\VideoInterface;

class VideoService
{
    protected $videoRepository;

    public function __construct(VideoInterface $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function all()
    {
        return $this->videoRepository->all();
    }

    public function find($id)
    {
        return $this->videoRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->videoRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->videoRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->videoRepository->delete($id);
    }
}
