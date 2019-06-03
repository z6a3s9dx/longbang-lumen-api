<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-05-16
 * Time: 13:24
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserLoginServices;
use Illuminate\Http\Request;
use Validator;


class UserLoginController extends Controller
{
    private $userLoginServices;

    public function __construct(UserLoginServices $userLoginServices)
    {
        $this->userLoginServices = $userLoginServices;
    }

    /**
     * 登入驗證
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function list(Request $request)
    {
        $limit = config('limit');

        $this->validate($request, [
            'user_account'  => $limit['users']['account'],
            'time'  => 'required|'.$limit['user_login']['time'],
            'time_end'  => 'required|'.$limit['user_login']['time'],
        ]);

        return $this->responseWithJson($request,$this->userLoginServices->list($request));
    }
}