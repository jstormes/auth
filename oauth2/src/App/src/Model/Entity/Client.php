<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/28/17
 * Time: 12:37 PM
 */

namespace App\Model\Entity;


class Client
{
    private $client_name="";
    private $roles=[];

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->client_name;
    }

    /**
     * @param string $client_name
     */
    public function setClientName($client_name)
    {
        $this->client_name = $client_name;
    }

}