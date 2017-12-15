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

    public function __construct(AdapterInterface $adapter)
    {
        $user           = new User($this);

        $hydrator       = new ClassMethods();

        $resultSet      = new HydratingResultSet($hydrator, $user);

        parent::__construct('user', $adapter, new MetadataFeature(), $resultSet);
    }

    public function fetch(int $id)
    {
        if ($id===null) {
            /* @var $tableGatewayPrototype \Zend\Db\ResultSet\HydratingResultSet */
            $tableGatewayPrototype = $this->getResultSetPrototype();
            return clone ($tableGatewayPrototype->getObjectPrototype());
        }

        $User = $this->select(array('user_id'=>$id))->current();

        return $User;
    }

    public function fetchAll(array $where = [], array $options = [])
    {
        $pageSize   =   25;
        $pageNumber =   0;

        if (isset($options['pageSize'])) {
            $pageSize = $options['pageSize'];
        }

        if (isset($options['pageNumber'])) {
            $pageNumber = $options['pageNumber'];
        }

        $sel = $this->sql->select();
        $sel->limit($pageSize);
        $sel->offset($pageNumber);

        $sel->where($where);

        $Users = $this->select($sel);

        return $Users;
    }

    public function save(User $user)
    {
        $hydrator = new ClassMethods();

        $data = $hydrator->extract($user);

        if (empty($data['user_id'])) {
            $data['user_id']=null;
            $this->insert($data);
        }
        else {
            $this->update($data,array('user_id'=>$data['user_id']));
        }
    }

    public function delete($where)
    {
        $where = ['user_id'=>$where->getUserId()];
        return parent::delete($where);
    }

}