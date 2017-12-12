<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 12/11/17
 * Time: 11:43 AM
 */

namespace App\Model\TableGateway;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature\MetadataFeature;

use App\Model\Entity\ContactMethodType;

class ContactMethodTypeTableGateway extends TableGateway
{

    public function __construct(AdapterInterface $adapter)
    {
        $contact_method_type    = new ContactMethodType($this);

        $hydrator               = new ClassMethods();

        $resultSet              = new HydratingResultSet($hydrator, $contact_method_type);

        parent::__construct('contact_method_type', $adapter, new MetadataFeature(), $resultSet);
    }

    public function fetchAll()
    {
        $select=$this->getSql()->select();
        $select->order('contact_method_type');
        return $this->select($select)->toArray();
    }

}