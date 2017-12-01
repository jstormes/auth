<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/28/17
 * Time: 1:28 PM
 */

namespace App\Library\Adapters;

use Interop\Container\ContainerInterface;

class authAdapterFactory
{

    public function __invoke(ContainerInterface $container)
    {


        return new authAdapter();
    }

}