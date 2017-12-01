<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/27/17
 * Time: 11:44 AM
 */

namespace App\Model\TableGateway;


use App\Model\TableGateway\UserTableFactory;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;
use App\Library\Adapters\authAdapter;


class UserTableGatewayFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter      = $container->get( Adapter::class );
        $authAdapter    = $container->get( authAdapter::class );

        $tableGateway   = new UserTableGateway($dbAdapter, $authAdapter);

        return $tableGateway;
    }

}