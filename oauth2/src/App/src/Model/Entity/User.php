<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/20/17
 * Time: 2:55 PM
 */

namespace App\Model\Entity;

use App\Model\TableGateway\ContactMethodTableGateway;

class User
{
    /**
     * @var string
     */
    private $user_id="";

    /**
     * @var string
     */
    private $user_name="";

    /**
     * @var string
     */
    private $password="";

    /**
     * @var string
     */
    private $name_addressed_by="";

    /**
     * @var string
     */
    private $full_name="";


    /**
     * @var \App\Model\Entity\Client[]
     */
    private $clients=[];

    private $adapter;




    public function __construct($adapter)
    {
        $this->adapter = $adapter;

    }

    /**
     * @return \App\Model\Entity\Client[]
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param \App\Model\Entity\Client[] $clients
     */
    public function setClients($clients)
    {
        $this->clients = $clients;
    }

    /**
     * @return string
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getUserName() : string
    {
        return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName(string $user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFullName() : string
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     */
    public function setFullName(string $full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getNameAddressedBy() : string
    {
        return $this->name_addressed_by;
    }

    /**
     * @param string $name_addressed_by
     */
    public function setNameAddressedBy(string $name_addressed_by)
    {
        $this->name_addressed_by = $name_addressed_by;
    }

    public function setContactMethods($contactMethod)
    {

    }

    public function getContactMethods()
    {
        $phoneTable = new ContactMethodTableGateway($this->adapter, null);
        return $phoneTable->select(array('user_id'=>$this->user_id));
    }

}