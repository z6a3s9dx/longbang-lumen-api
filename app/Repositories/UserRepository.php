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
}
