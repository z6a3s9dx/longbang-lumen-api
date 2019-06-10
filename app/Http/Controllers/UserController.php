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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $limit = config('limit.users');
        $this->validate($request, [
            'account'  => 'required|'.$limit['account'],
            'password' => 'required|'.$limit['password'],
        ]);

        return $this->responseWithJson($request, $this->userServices->login($request));
    }

    /**
     * 取得使用者清單資訊
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request)
    {
        $limit = config('limit.users');
        $validator=Validator::make($request->all(), [
            'account'  => $limit['account'],
        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }
        return $this->responseWithJson($request, $this->userServices->list($request));
    }

    /**
     *新增使用者
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $limit = config('limit');
        $validator=Validator::make($request->all(), [
            'account'  => 'required|'.$limit['users']['account'],
            'password' => 'required|'.$limit['user_confirmed']['password'],
            'password_confirmation' => 'required|'.$limit['user_confirmed']['password_confirmation'],
        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'result' => '', 'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }

        return $this->responseWithJson($request, $this->userServices->create($request));
    }

    /**
     *編輯使用者
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editUser(Request $request)
    {
        //
        $limit = config('limit');
        $this->validate($request, [
            'account'  => 'required|'.$limit['users']['account'],
            'password' => 'required|'.$limit['user_confirmed']['password'],
            'password_confirmation' => 'required|'.$limit['user_confirmed']['password_confirmation'],
        ]);

        return $this->responseWithJson($request, $this->userServices->editUser($request));
    }

    /**
     *刪除使用者
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request)
    {
        $limit = config('limit.users');
        $validator=Validator::make($request->all(), [
            'account'  => $limit['account'],
        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }
        //dd($request->all());
        return $this->responseWithJson($request, $this->userServices->delete($request));
    }

}
