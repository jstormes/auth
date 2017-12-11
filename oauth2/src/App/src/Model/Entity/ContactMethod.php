<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/30/17
 * Time: 7:29 PM
 */

namespace App\Model\Entity;


class ContactMethod
{
    /**
     * @var int
     */
    private $contact_method_id       = 0;

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
    private $contact_value   = ' ';


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
        //$t=$this->tableGateway->getColumns();
        //$t2=$this->tableGateway->getFeatureSet();
        //$t3=$this->tableGateway->getTable();
        //$t3->getColumns();
        //$info = $this->tableGateway->getInfofTable();
        // TODO: Change this to read from DB enum options.
        return ['unknown','landline','mobile','skype'];
        //return $this->types;
    }

    /**
     * @return int
     */
    public function getContactMethodId()
    {
        return $this->contact_method_id;
    }

    /**
     * @param int $contact_method_id
     */
    public function setContactMethodId($contact_method_id)
    {
        $this->contact_method_id = $contact_method_id;
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
    public function getContactValue()
    {
        return $this->contact_value;
    }

    /**
     * @param string $contact_value
     */
    public function setContactValue($contact_value)
    {
        $this->contact_value = $contact_value;
    }


}