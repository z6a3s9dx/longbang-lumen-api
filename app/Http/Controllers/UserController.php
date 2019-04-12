<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserServices;
use Validator;

class UserController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    /**
     * 登入驗證
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {
        $limit = config('limit.users');
        $this->validate($request, [
            'account'  => 'required|'.$limit['account'],
            'password' => 'required|'.$limit['password'],
        ]);
        return $this->responseWithJson($request, $this->userServices->login($request->all()));
    }
}
