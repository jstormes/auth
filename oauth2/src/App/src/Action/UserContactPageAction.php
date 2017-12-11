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


class UserContactPageAction implements ServerMiddlewareInterface
{
    private $router;

    private $template;

    /**
     * @var UserTableGateway
     */
    private $table;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, AbstractTableGateway $table)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->table    = $table;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {

        $form_data=[];
        try {

            $user_id=$request->getAttribute('user_id',null);
            $contact_method_id=$request->getAttribute('contact_method_id',null);

            $form_data['is_new_contact_method'] = ($contact_method_id===null);

            $contact_method = $this->table->fetch($contact_method_id);

            $contact_method->setUserId($user_id);

            if ($request->getMethod()=='POST') {

                $form = $request->getParsedBody();

                $hydrator = new \Zend\Hydrator\ClassMethods();
                $hydrator->hydrate($form, $contact_method);

                if ($form['action']=='save') {
                    $this->table->save($contact_method);
                }

                if ($form['action']=='delete') {
                    $this->table->delete($contact_method);
                }

                return new HtmlResponse($this->template->render('app::parent-refresh', $form_data));
                //return new RedirectResponse('/parentrefresh.html');
            }

        }
        catch (\Exception $e) {
            $form_data['error']=$e->getMessage();
        }

        $form_data['contact_method']=$contact_method;
        return new HtmlResponse($this->template->render('app::user-contact-page', $form_data));
    }

}
