<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/26/2017
 * Time: 1:39 PM
 */

namespace  App\Model\HtmlGateway;

use Interop\Container\ContainerInterface;

class HeaderHtmlGatewayFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $htmlGateway   = new HeaderHtmlGateway('src/App/templates/layout/header.phtml');

        return $htmlGateway;
    }
}