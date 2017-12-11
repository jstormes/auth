<?php

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Model\UsersTable;

class UserContactPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $table = $container->get( 'ContactMethodTable' );
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new UserContactPageAction($router, $template, $table);
    }
}
