<?php
/**
 * Created by PhpStorm.
 * User: thoth
 * Date: 2019-06-03
 * Time: 14:47
 */

namespace App\Repositories;


use App\Entities\Members;

class MembersRepository
{
    public function create($parameters)
    {
        return Members::create($parameters);
    }

    public function find($id)
    {
        return Members::find($id);
    }

    public function editUser($id,$parameters)
    {
        return Members::find($id)->update($parameters);
    }

    /*public function whereAccount($password)
    {
        return Members::where('password', $password);
    }*/

    public function delete($id)
    {
        return Members::destroy($id);
    }
}