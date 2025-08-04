<?php

namespace Modules\Core\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Core\Traits\ApiResponse;

class UserBaseController extends Controller
{
    use ApiResponse,AuthorizesRequests;
}
