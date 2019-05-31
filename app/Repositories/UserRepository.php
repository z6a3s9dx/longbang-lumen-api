<?php

namespace App\Repositories;

use App\Entities\User;

class UserRepository
{
    /**
     * 更新單筆資料
     *
     * @param  integer  $id
     * @param  array    $parameters
     * @return mixed
     */
    public function update($id, $parameters)
    {
        return User::find($id)->update($parameters);
    }

   /* public function initQuery()
    {
        return User::select(['id', 'account']);
    }

    public function whereAccount($query, $account)
    {
        return $query->where('account', $account);
    }

    public function getData($query)
    {
        return $query->orderBy('id', 'DESC')->paginate(5);
    }*/

    public function getUserList($account)
    {
        //dd(456);
        //return User::where('account',$account)->get();
        $query = User::select();
        if ($account != '') {
            $query = $query->where('account', $account);
        }

        return $query->get();

    }

    public function create($parameters)
    {
        return User::create($parameters);
    }

    public function editUser($id, $parameters)
    {
        return User::find($id)->update($parameters);
    }

    public function find()
    {
        return User::get();
    }

    public function delete($id, $account)
    {
        return User::find($id)->destroy($account);
    }

    public function oldToken()
    {
        return User::get();
    }
}
