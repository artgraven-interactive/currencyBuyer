<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();
        
      if($auth_checker->isGranted('ROLE_ADMIN') ){
        
        return $this->redirectToRoute('admin_dashboard');
        
        }elseif($auth_checker->isGranted('IS_AUTHENTICATED_FULLY')){
        
        return $this->redirectToRoute('user_dashboard');
        }else{
           
           //not yet logged in lets redirect to login for now.
           // in future we will redirect to normal web view
           return $this->redirectToRoute('fos_user_security_login');
        }
    }
    
    
    /**
     * @Route("/welcome", name="user_dashboard")
     */
    public function WelcomeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rates = $em->getRepository('AppBundle:Rates')->findAll();
         return $this->render('default/user-dashboard.twig',array('rates' => $rates));
    }
}
