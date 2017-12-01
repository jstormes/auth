<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/16/17
 * Time: 12:59 PM
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Zend\Db\TableGateway\AbstractTableGateway;

class UsersPageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    private $table;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, $table)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->table    = $table;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {

        $data = [];

        $columns = $this->table->getColumns();

        $data['columns'] = $columns;
        $data['rows'] = $this->table->select();


        $data['isActionable'] = true;
        $data['actionColumn'] = 'user_id';

        return new HtmlResponse($this->template->render('app::users-page', $data));
    }
}
