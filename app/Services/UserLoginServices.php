<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-05-16
 * Time: 13:23
 */

namespace App\Services;


use App\Repositories\UserLoginRepository;
use Tymon\JWTAuth\JWTAuth;


class UserLoginServices
{
    private $UserLoginRepository;
    private $JWTAuth;

    public function __construct(
        UserLoginRepository $UserLoginRepository,
        JWTAuth $JWTAuth
    ){
        $this->UserLoginRepository = $UserLoginRepository;
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * 使用者登入日誌
     *
     * @param  Request $request
     * @return array
     */
    public function list($request)
    {
        try {
                //dd(['time' => $request['time']]);
//            if (['user_account' => $request['user_account']] != '')
//            {

             $user_log = $this->UserLoginRepository->list(
                 $request->input('user_account'),
                 ['time' => $request['time']],
                 ['time_end' => $request['time_end']]
             );
             //dd(123);
//            }else{
//                $user_log = $this->UserLoginServices->index(
//                    ['time' => $request['time']],
//                    ['time_end' => $request['time_end']]
//                );
//            }
            return [
                'code'   => config('apiCode.success'),
                'result' => $user_log,
            ];
        } catch (\Exception $e) {
            return [
                'code'  => $e->getCode() ?? config('apiCode.notAPICode'),
                'error' => $e->getMessage(),
            ];
        }
    }
}