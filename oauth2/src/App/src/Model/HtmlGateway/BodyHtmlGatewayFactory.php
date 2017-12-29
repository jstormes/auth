<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/22/2017
 * Time: 10:30 AM
 */

namespace  App\Model\HtmlGateway;

use Interop\Container\ContainerInterface;


class BodyHtmlGatewayFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $header = $container->get(\App\Model\HtmlGateway\HeaderHtmlGateway::class);
        $footer = $container->get(\App\Model\HtmlGateway\FooterHtmlGateway::class);

        $htmlGateway   = new BodyHtmlGateway('src/App/templates/layout/default.phtml');
        $htmlGateway->addToSection('header',$header);
        $htmlGateway->addToSection('footer',$footer);


        return $htmlGateway;
    }

}