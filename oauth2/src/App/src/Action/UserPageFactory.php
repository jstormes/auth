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
        $userTable = $container->get( 'UserTable' );

        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new UserPageAction($userTable, $template);
    }
}
