<?php

namespace App\Services\Father;

use App\Interfaces\Father\FatherSettingInterface;

class FatherSettingService
{
    public function __construct(protected FatherSettingInterface $fatherSettingRepository)
    {
    }

    public function all() {
        return $this->fatherSettingRepository->all();
    }

    public function update($father, array $data)
    {
        return $this->fatherSettingRepository->update($father, $data);
    }

    public function approve($id)
    {
        return $this->fatherSettingRepository->approve($id);
    }

}
