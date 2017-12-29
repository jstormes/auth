<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/20/2017
 * Time: 10:54 AM
 */

namespace App\Model\HtmlGateway;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


class HeaderHtmlGatewayFactory_old
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $templateEngine = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $htmlGateway   = new HeaderHtmlGateway('app::header',$templateEngine);

        return $htmlGateway;
    }

}