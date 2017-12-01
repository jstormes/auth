<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Model\UsersTable;

class UserPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $table = $container->get( 'UserTable' );
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new UserPageAction($router, $template, $table);
    }
}
