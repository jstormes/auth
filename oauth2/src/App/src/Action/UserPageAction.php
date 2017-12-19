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
        // $this->userContactTable  = $userContactTable;
        // $this->userClientTable   = $userClientTable;
        // $this->userHtmlGateway   = $userHtmlGateway;
        // $this->userContactHtmlGateway = $userContactHtmlGateway;
        // $this->userClientHtmlGateway = $userClientHtmlGateway;
        // $this->htmlHeaderGateway = $htmlHeaderGateway;
    }

    public function processHtml()
    {

    }

    public function processCli()
    {

    }

    public function processJson()
    {

    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        //if ($request->accept==='json/text') {
        //  return ($this->processJson($request));
        // }
        //if ($request->type === 'cli') {
        //  return ($this->processCli($request));
        //}
        //return ($this->processHtml($request));


//        $data['user']           = $userTable->fetch($userId);
//        $data['user_contacts']   = $userContactTable->fetch($userId);
//        $data['user_clients']    = $userClientTable->fetch($userId);
        $form_data=[];
        try {

            $user_id=$request->getAttribute('user_id',null);

            // TODO: Code stink, crosses the streams.
            $form_data['is_new_user'] = ($user_id===null);

            $user = $this->userTable->fetch($user_id);

            // $userHtmlForm = new userHtmlForm($user, $template);
            // $contactsHtmlForm = new contactsHtmlForm($contacts, $template);
            // $clientsHtmlForm = new clientsHtmlForm($clients, $template);

            if ($request->getMethod()=='POST') {


                // $user = $userHtmlForm->fetch($request, $user);
                // $contacts = $contactsHtmlForm->fetch($request, $contacts);
                // $clients = $clientsHtmlForm->fetch($request, $clients);
                $form = $request->getParsedBody();

                $hydrator = new \Zend\Hydrator\ClassMethods();
                $hydrator->hydrate($form, $user);

                if ($form['action']==='save') {
                    $user->save();
                    //$this->userTable->save($user);
                }

                if ($form['action']==='delete') {
                    $user->delete();
                    //$this->userTable->delete($user);
                }

                //$alert['notice']='new_user_created';
                return new RedirectResponse('/users');
            }

        }
        catch (\Exception $e) {
            //$alert['error']=$e->getMessage();
            $form_data['error']=$e->getMessage();
        }

        $form_data['contact_types']['contact_method_type']=['unknown','email','skype'];

        $form_data['user']=$user;
        $form_data['user_contact']=[];
        $form_data['user_clients']=[];

        //$html = $this->headerHtmlForm->render($alerts[]);
        //$html .= $userHtmlForm->render( $user);
        //$html .= $contactsHtmlForm->render( $userContacts);
        //$html .= $clientsHtmlForm->render( $userClients);


        return new HtmlResponse($this->template->render('app::user-page', $form_data));
    }

}
