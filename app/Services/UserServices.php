<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\UserLoginRepository;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserServices
{
    private $userRepository;
    private $userLoginRepository;

    protected $JWTAuth;

    public function __construct(
        UserRepository $userRepository,
        UserLoginRepository $userLoginRepository,
        JWTAuth $JWTAuth
    ) {
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * 登入驗證
     *
     * @param  Request $request [需有id、account]
     * @return array
     */
    public function login($request)
    {

        $user = [];
        // 驗證帳號密碼是否正確
        try {

            if (!$user['token'] = $this->JWTAuth->attempt([
                'account'  => $request['account'],
                'password' => $request['password'],
                'active'   => 1,
            ])) {
                return [
                    'code'  => config('apiCode.invalidCredentials'),
                    'error' => 'invalid credentials',
                ];
            }
        } catch (JWTException $e) {
            return [
                'code'  => config('apiCode.couldNotCreateToken'),
                'error' => 'could not create token',
            ];
        }

        // 取得 token 並更新該人員 token 資訊
        try {
            $user['user'] = $this->JWTAuth->setToken($user['token'])->toUser();
            $this->userRepository->update($user['user']->id, ['token' => $user['token']]);

            $this->userLoginRepository->create([
                'user_id' =>$user['user']['id'],
                'user_account' => $user['user']['account'],
                'user_name' => $user['user']['name'],
                'login_ip' => $request->ip(),
                'status' => $user['user']['active'],
            ]);
            //dd($test);
            return [
                'code'   => config('apiCode.success'),
                'result' => $user,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 取得使用者清單資訊
     *
     * @param  Request $request  [需有account]
     * @return array
     */
    public function list($request)
    {
        try {
            //dd($id);
                $user = $this->userRepository->getUserList(['account'=>$request['account']]);
            return [
                'code'   => config('apiCode.success'),
                'result' => $user,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 新增使用者
     *
     * @param  Request $request [需有account、password]
     * @return array
     */
    public function create($request)
    {

        try{
            $result = $this->userRepository->create([
                'account' => $request['account'],
                'password' => Hash::make('password'),
                'active' => 1,
            ]);
            //dd($result);
            return [
                'code'   => config('apiCode.success'),
                'result' => $result,
            ];
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 編輯使用者
     *
     * @param  Request $request [需有account、password、name、active]
     * @return array
     */
    public function editUser($request)
    {
        try{
            $parseToken = $this->JWTAuth->parseToken()->authenticate();
            //dd($parseToken);
            $result = $this->userRepository->editUser($parseToken['id'],[
                'account' => $request['account'],
                'password' => Hash::make($request['password']),
                'name' => $request['name'],
                'active' =>$request['active'],
            ]);
            //若有修改到admin密碼則會登出

            //dd($result);
            return [
                'code'   => config('apiCode.success'),
                'result' => $result
            ];
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * 刪除使用者
     *
     * @param  Request $request
     * @return array
     */
    public function delete()
    {
        try{
            $parseToken = $this->JWTAuth->parseToken()->authenticate();
            //dd($parseToken['id']);
            if ($parseToken['account'] !== "thothadmin")
            {
                $result = $this->userRepository->delete($parseToken['id']);
                //dd($result);
                return [
                    'code'   => config('apiCode.success'),
                    'result' => $result
                ];
            }else{
                return[
                  'code' => config('apiCode.validateFail'),
                  'error' => 'admin'
                ];
            }
        }catch (\Exception $e){
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }

}
