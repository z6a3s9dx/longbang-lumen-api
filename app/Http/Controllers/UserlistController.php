<?php

namespace App\Http\Controllers;

use App\Services\UserlistServices;
use Illuminate\Http\Request;

class UserlistController extends Controller
{
    //
    private $userListServices;

    public function __construct(UserlistServices $userListServices)
    {
        $this->userListServices = $userListServices;
    }
}
