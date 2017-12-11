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

use App\Model\Entity\User;

class UserTableGateway extends TableGateway
{

    public function __construct(AdapterInterface $adapter, $authAdapter)
    {
        $user           = new User($adapter);

        $hydrator       = new ClassMethods();

        $resultSet      = new HydratingResultSet($hydrator, $user);

        parent::__construct('user', $adapter, new MetadataFeature(), $resultSet);
    }

    public function save($user)
    {
        $hydrator = new ClassMethods();

        $data = $hydrator->extract($user);

//        foreach($data as $key=>$value) {
//            switch (gettype($value)) {
//                case 'object':
//                    $this->saveObject($value);
//                case 'array':
//                    $this->saveArray($value);
//                    unset($data[$key]);
//                    break;
//            }
//        }

        if (empty($data['user_id'])) {
            $data['user_id']=null;
            $this->insert($data);
        }
        else {
            $this->update($data,array('user_id'=>$data['user_id']));
        }

    }

    public function fetch($id) {

        if ($id===null) {
            $tableGatewayPrototype = $this->getResultSetPrototype();
            return clone ($tableGatewayPrototype->getObjectPrototype());
        }

        return $this->select(array('user_id'=>$id))->current();
    }

    public function delete($user) {
        return parent::delete(array('user_id'=>$user->getUserId()));
    }

//    public function saveObject($object) {
//
//    }
//
//    public function saveArray($data) {
//
//    }

}