<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/28/17
 * Time: 1:24 PM
 */

namespace App\Library\Adapters;


class authAdapter
{
    public function __construct($jwt=null,$keys=null) {
        // decode $JWT
        // validate $JWT
    }

    public function hasRole($role) {
        return true;
    }

    public function hasAnyRoles($roles) {
        return true;
    }

    public function hasAllRoles($roles) {
        return true;
    }
}