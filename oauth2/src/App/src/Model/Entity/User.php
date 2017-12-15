<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/20/17
 * Time: 2:55 PM
 */

namespace App\Model\Entity;

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
     * @var object
     */
    private $gateway=null;

    /**
     * User constructor.
     * @param object|null $gateway
     */
    public function __construct($gateway=null)
    {
        $this->gateway = $gateway;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id)
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
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
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

    /**
     * @throws \Exception
     */
    public function save()
    {
        if ($this->gateway===null) {
            throw new \Exception("User->save() not available.");
        }

        $this->gateway->save($this);
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->gateway===null) {
            throw new \Exception("User->delete() not available.");
        }

        $this->gateway->delete(array('user_id'=>$this->user_id));
    }

}