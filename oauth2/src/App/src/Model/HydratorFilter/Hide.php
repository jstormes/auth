<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/30/17
 * Time: 11:11 AM
 */

class Hide
{
    public function hide($hydrator) {
        $hydrator->addFilter('clients', function ($property) {
            $t=($property !== 'App\Model\Entity\User::getClients');

            return $t;
        }, \Zend\Hydrator\Filter\FilterComposite::CONDITION_AND);
    }
}