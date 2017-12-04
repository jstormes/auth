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

use App\Model\Entity\Phone;

class PhoneTableGateway extends TableGateway
{

    public function __construct(AdapterInterface $adapter)
    {
        $phone          = new Phone($this);

        $hydrator       = new ClassMethods();

        $resultSet      = new HydratingResultSet($hydrator, $phone);

        parent::__construct('phone', $adapter, new MetadataFeature(), $resultSet);
    }

    function getInfofTable()
    {
        $m = $this->getColumn('type');

        //$column = $columns['type'];
        $data = $this->getInfo();
        return $data;
    }
}