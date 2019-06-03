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

    public function list($account,$time,$time_end)
    {
        //return UserLogin::where('user_account',$account);
        //dd(123);
        $query = UserLogin::select();
        if ($account != '') {
            $query = UserLogin::where('user_account', $account);
        }

        return $query->whereBetween('created_at',array($time,$time_end))->paginate(5);
    }

   /* public function getData()
    {
        return UserLogin::orderBy('id', 'DESC')->paginate(5);
    }*/

    /*public function index($time,$time_end)
    {
        return UserLogin::whereBetween('created_at',array($time,$time_end))->get();
    }*/
}