<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/30/17
 * Time: 7:29 PM
 */

namespace App\Model\Entity;


class Phone
{
    /**
     * @var int
     */
    private $phone_id       = 0;

    /**
     * @var int
     */
    private $user_id        = 0;

    /**
     * @var string
     */
    private $type           = 'unknown';

    /**
     * @var string
     */
    private $phone_number   = ' ';

    /**
     * @var array
     */
    private $types          = [];

    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    private $tableGateway   = null;

    public function __construct($tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        $t=$this->tableGateway->getColumns();
        $t2=$this->tableGateway->getFeatureSet();
        $t3=$this->tableGateway->getTable();
        //$t3->getColumns();
        //$info = $this->tableGateway->getInfofTable();
        return $this->types;
    }

    /**
     * @return int
     */
    public function getPhoneId()
    {
        return $this->phone_id;
    }

    /**
     * @param int $phone_id
     */
    public function setPhoneId($phone_id)
    {
        $this->phone_id = $phone_id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }


}