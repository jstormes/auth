<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/27/2017
 * Time: 1:46 PM
 */

namespace  App\Model\HtmlGateway;

use Interop\Container\ContainerInterface;

class UserContactHtmlGatewayFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $htmlGateway   = new UserContactHtmlGateway('src/App/templates/app/user-contact-page.phtml');

        return $htmlGateway;
    }

}