<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/28/17
 * Time: 12:38 PM
 */

namespace App\Model\Entity;


class Role
{
    private $role_name="";

    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param string $role_name
     */
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
    }



}