<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/17/17
 * Time: 2:13 PM
 */

namespace App\Service;

use Interop\Container\ContainerInterface;

class AdapterServiceFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $db          = $container->get( 'config' )->db;
        $dbAdapter = new AdapterServiceFactory($db);
        return $dbAdapter;
    }

}