<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/16/17
 * Time: 12:59 PM
 */

namespace App\Action;

use App\Model\Entity\User;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Zend\Db\TableGateway\AbstractTableGateway;
use App\Model\UserTableGateway;


class UserPageAction implements ServerMiddlewareInterface
{
    /**
     * @var Template\TemplateRendererInterface
     */
    private $template;

    /**
     * @var UserTableGateway
     */
    private $userTable;

    public function __construct(AbstractTableGateway $userTable, Template\TemplateRendererInterface $template = null)
    {
        $this->template             = $template;
        $this->userTable            = $userTable;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {

        $form_data=[];
        try {

            $user_id=$request->getAttribute('user_id',null);

            $form_data['is_new_user'] = ($user_id===null);

            $user = $this->userTable->fetch($user_id);

            if ($request->getMethod()=='POST') {

                $form = $request->getParsedBody();

                $hydrator = new \Zend\Hydrator\ClassMethods();
                $hydrator->hydrate($form, $user);

                if ($form['action']=='save') {
                    $this->userTable->save($user);
                }

                if ($form['action']=='delete') {
                    $this->userTable->delete($user);
                }

                return new RedirectResponse('/users');
            }

        }
        catch (\Exception $e) {
            $form_data['error']=$e->getMessage();
        }

        $form_data['user']=$user;
        return new HtmlResponse($this->template->render('app::user-page', $form_data));
    }

}
