<?php
/**
 * Created by PhpStorm.
 * User: jstormes
 * Date: 11/16/17
 * Time: 12:59 PM
 */

namespace App\Action;

use App\Model\Entity\User;
use App\Model\HtmlGateway\HeaderHtmlGatewayFactory;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use PHPUnit\Runner\Exception;
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
use App\Model\HtmlGateway\UserHtmlGateway;
use App\Model\HtmlGateway\BodyHtmlGateway;


class UserPageAction implements ServerMiddlewareInterface
{
    /**
     * @var BodyHtmlGateway
     */
    private $bodyHtmlGateway;

    /**
     * @var UserHtmlGateway
     */
    private $userHtmlGateway;

    /**
     * @var ContactHtmlGateway
     */
    private $contactHtmlGateway;

    /**
     * @var UserTableGateway
     */
    private $userTableGateway;

    /**
     * @var ContactTableGateway
     */
    private $contactTableGateway;

    /**
     * @param BodyHtmlGateway $bodyHtmlGateway
     */
    public function setBodyHtmlGateway($bodyHtmlGateway)
    {
        $this->bodyHtmlGateway = $bodyHtmlGateway;
        return $this;
    }

    /**
     * @param UserHtmlGateway $userHtmlGateway
     */
    public function setUserHtmlGateway($userHtmlGateway)
    {
        $this->userHtmlGateway = $userHtmlGateway;
        return $this;
    }

    /**
     * @param ContactHtmlGateway $contactHtmlGateway
     */
    public function setContactHtmlGateway($contactHtmlGateway)
    {
        $this->contactHtmlGateway = $contactHtmlGateway;
        return $this;
    }

    /**
     * @param UserTableGateway $userTableGateway
     */
    public function setUserTableGateway($userTableGateway)
    {
        $this->userTableGateway = $userTableGateway;
        return $this;
    }

    /**
     * @param ContactTableGateway $contactTableGateway
     */
    public function setContactTableGateway($contactTableGateway)
    {
        $this->contactTableGateway = $contactTableGateway;
        return $this;
    }

    public function __construct()
    {


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
        //try {
            $user_id = $request->getAttribute('user_id', null);

            $user = $this->userTableGateway->fetch($user_id);
            $userContact = $this->contactTableGateway->fetch($user_id);


            $html = $this->bodyHtmlGateway
                ->addToSection('content',$this->userHtmlGateway,$user);
                //->addToSection('content',$this->contactHtmlGateway,['user_contact'=>$userContact])


//        }
//        catch (\Exception $e) {
//            $form_data['error']=$e->getMessage();
//            $html = $e->getMessage();
//        }
        return new HtmlResponse($html->render('head'));


        $html = $this->headerGateway->render('user_info');
        //$html .= $this->userHtml->render($user);
        return new HtmlResponse($html);


        $user =  $this->userTable->fetch($user_id);
        $contact = $this->contactTable->fetch($user_id);

        $user = $this->userHtml->process($request, 'user_action', $user);
        $contact = $this->contactHtml->process($request, 'contact_action', $user);

        return new HtmlResponse(
            $this->HtmlBodyGateway
                ->addToSection('content',$this->userHtmlGateway,$user)
                ->addToSection('content',$this->contactHtmlGateway,$contact)
                ->render(['title'=>'title','error'=>$error])
        );

//            ->addTitle('title')
//            ->addGateway($this->userHtml,$user)
//            ->addGateway($this->contactHtml,$contacts)
//            ->addJavaScriptFileTop($asdfasd)
//            ->addJavascriptFileBottom($dafdasfa)
//            ->addCss($adfasdf)
//            ->addMeta($afdsfas)
//            ->render();

        // Call all the render() functions
        $this->HtmlTemplate()->render();

        $this->JasonGateway()
            ->add('user',$user)
            ->contact('contact',$contact)
            ->client('client',$client)
            ->render();

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
