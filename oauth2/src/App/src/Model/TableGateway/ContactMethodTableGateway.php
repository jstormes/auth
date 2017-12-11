<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/17/17
 * Time: 8:25 PM
 */

namespace App\Model\TableGateway;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature\MetadataFeature;

use App\Model\Entity\ContactMethod;

class ContactMethodTableGateway extends TableGateway
{

    public function __construct(AdapterInterface $adapter)
    {
        $contact_method = new ContactMethod($this);

        $hydrator       = new ClassMethods();

        $resultSet      = new HydratingResultSet($hydrator, $contact_method);

        parent::__construct('contact_method', $adapter, new MetadataFeature(), $resultSet);
    }

}