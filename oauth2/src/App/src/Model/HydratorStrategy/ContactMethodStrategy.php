<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 12/11/17
 * Time: 11:16 AM
 */

namespace App\Model\HydratorStrategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use Zend\Db\TableGateway\TableGateway;

class ContactMethodStrategy implements StrategyInterface
{
    public function __construct(TableGateway $ConnectMethodTypeTable)
    {

    }

    public function extract($value)
    {
        return $value;
        // TODO: Implement extract() method.
    }

    public function hydrate($value)
    {
        return $value;
        // TODO: Implement hydrate() method.
    }
}