<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use ApiResponse ,AuthorizesRequests;
}
