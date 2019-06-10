<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-06-03
 * Time: 14:24
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MembersServices;
use Illuminate\Http\Request;
use Validator;

class MembersController extends Controller
{
    private $membersServices;

    public function __construct(MembersServices $membersServices)
    {
        $this->membersServices = $membersServices;
    }

    public function create(Request $request)
    {
        $limit = config('limit.members');
        $validator= Validator::make($request->all(), [
            'mobile'  => 'required|'.$limit['mobile'],

        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }

        return $this->responseWithJson($request, $this->membersServices->create($request));
    }

    public function apiGet(Request $request)
    {
        $limit = config('limit.users');
        $validator= Validator::make($request->all(), [
            'account'  => 'required|'.$limit['account']
        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }

        return $this->membersServices->apiGet($request);
    }

    public function editUser(Request $request,$id)
    {
        //$limit = config('limit.user_confirmed');
        $validator= Validator::make($request->all(), [
            'active' => 'required',
            'password'  => 'between:8,12|confirmed',
            'password_confirmation'  => 'between:8,12',

        ]);
        // 驗證參數
        if ($validator->fails()) {
            return $this->responseWithJson($request, [
                'code' => config('apiCode.validateFail'),
                'error' => $validator->errors()->first()
            ]);
        }

        return $this->responseWithJson($request, $this->membersServices->editUser($id,$request));
    }

    public function delete(Request $request,$id)
    {

        return $this->responseWithJson($request, $this->membersServices->delete($id));
    }
}