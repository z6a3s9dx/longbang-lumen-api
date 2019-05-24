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

    public function list(Request $request)
    {
        //dd($request->all());
        $limit = config('limit');

        //$limit_account = config('limit.user_login');

        $this->validate($request, [
            'user_account'  => 'required|'.$limit['users']['account'],
            'time'  => 'required|'.$limit['user_login']['time'],
            'time_end'  => 'required|'.$limit['user_login']['time'],
        ]);       // $test=dd($test);

        return $this->responseWithJson($request,$this->userLoginServices->list($request));
    }
}