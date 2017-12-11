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

        $contactMethod  = new ContactMethod($this);

        $hydrator       = new ClassMethods();

        $resultSet      = new HydratingResultSet($hydrator, $contactMethod);

        parent::__construct('contact_method', $adapter, new MetadataFeature(), $resultSet);
    }


    public function fetch($id) {

        if ($id===null) {
            $tableGatewayPrototype = $this->getResultSetPrototype();
            return clone ($tableGatewayPrototype->getObjectPrototype());
        }

        return $this->select(array('contact_method_id'=>$id))->current();
    }

    public function save($contact_method)
    {
        $hydrator = new ClassMethods();

        $data = $hydrator->extract($contact_method);

        // TODO: Hack get rid of me...
        unset($data['types']);

        if (empty($data['contact_method_id'])) {
            $data['contact_method_id']=null;
            $this->insert($data);
        }
        else {
            $this->update($data,array('contact_method_id'=>$data['contact_method_id']));
        }

    }

    public function delete($contact_method)
    {
        return parent::delete(array('contact_method_id'=>$contact_method->getContactMethodId()));
    }

}