<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class UserServices
{
    private $userRepository;

    protected $JWTAuth;

    public function __construct(
        UserRepository $userRepository,
        JWTAuth $JWTAuth
    ) {
        $this->userRepository = $userRepository;
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * 登入驗證
     *
     * @param  Request $request
     * @return array
     */
    public function login(array $request) : array
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
}
