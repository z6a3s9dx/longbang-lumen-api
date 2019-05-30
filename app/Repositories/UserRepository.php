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

    public function getUserList($account)
    {
        return User::where($account)->get();
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

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function oldToken()
    {
        return User::get();
    }
}
