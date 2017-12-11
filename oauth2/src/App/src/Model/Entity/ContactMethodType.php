<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 12/11/17
 * Time: 11:41 AM
 */

namespace App\Model\Entity;


class ContactMethodType
{
    private $contact_method_type;

    /**
     * @return mixed
     */
    public function getContactMethodType()
    {
        return $this->contact_method_type;
    }

    /**
     * @param mixed $contact_method_type
     */
    public function setContactMethodType($contact_method_type)
    {
        $this->contact_method_type = $contact_method_type;
    }
}