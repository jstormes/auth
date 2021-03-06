<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/27/17
 * Time: 11:44 AM
 */

namespace App\Model\TableGateway;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\Adapter;


class UserTableGatewayFactory
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter      = $container->get( Adapter::class );

        $tableGateway   = new UserTableGateway($dbAdapter);

        return $tableGateway;
    }

}