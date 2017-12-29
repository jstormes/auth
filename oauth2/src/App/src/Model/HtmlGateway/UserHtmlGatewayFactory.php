<?php
/**
 * Created by PhpStorm.
 * User: james.s
 * Date: 12/19/2017
 * Time: 1:36 PM
 */

namespace  App\Model\HtmlGateway;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class UserHtmlGatewayFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $htmlGateway = new UserHtmlGateway('src/App/templates/app/user-page.phtml');

        return $htmlGateway;

        $templateEngine = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $htmlGateway   = new UserHtmlGateway('app::user-record',$templateEngine);

        return $htmlGateway;
    }
}