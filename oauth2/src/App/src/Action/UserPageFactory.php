<?php

namespace App\Action;

use App\Model\HtmlGateway\HeaderHtmlGatewayFactory;
use App\Model\HtmlGateway\UserContactHtmlGateway;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Model\UsersTable;

use App\Model\HtmlGateway\UserHtmlGateway;

use App\Model\HtmlGateway\BodyHtmlGateway;

class UserPageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $UserPageAction = new UserPageAction();

        $UserPageAction->setBodyHtmlGateway($container->get(BodyHtmlGateway::class));
        $UserPageAction->setUserHtmlGateway($container->get(UserHtmlGateway::class));
        $UserPageAction->setUserTableGateway($container->get( 'UserTable' ));
        $UserPageAction->setContactTableGateway($container->get( 'ContactMethodTable' ));
        $UserPageAction->setContactHtmlGateway($container->get(UserContactHtmlGateway::class));

        return $UserPageAction;

//        $userTable = $container->get( 'UserTable' );
//
//
//        $userHtml = $container->get(UserHtmlGateway::class);
//
//        $headerHtml = $container->get(BodyHtmlGateway::class);
//
//        return new UserPageAction($headerHtml, $userTable, $userHtml);
    }
}
