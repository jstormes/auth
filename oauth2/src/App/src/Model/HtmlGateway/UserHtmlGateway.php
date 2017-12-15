<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/13/2017
 * Time: 2:27 PM
 */

use Psr\Http\Message\ServerRequestInterface;
use Zend\Hydrator\ClassMethods;

class UserHtmlGateway
{
    //private $request = null;
    private $user = null;
    private $hydrator = null;

    public function __construct()
    {
        //$this->request=$request;

        $this->user           = new User($this);

        $this->hydrator       = new ClassMethods();
    }

    public function setPrototype($Prototype)
    {
        $this->user = $Prototype;
    }

    public function fetch(ServerRequestInterface $request)
    {
        $form = $request->getParsedBody();
        $user = clone($this->user);

        $this->hydrator->hydrate($form, $user);

        return $user;
    }
}