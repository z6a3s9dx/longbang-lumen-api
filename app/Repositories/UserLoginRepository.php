<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-05-16
 * Time: 13:21
 */
namespace App\Repositories;

use App\Entities\UserLogin;

class UserLoginRepository
{
    public function create($parameters)
    {
        return UserLogin::create($parameters);
    }

    public function  list($account,$time,$time_end)
    {
        //dd(UserLogin::where($account));
        //return UserLogin::where($account)->get();
        return UserLogin::where($account)->whereBetween('created_at',[$time,$time_end])->get();

    }
}