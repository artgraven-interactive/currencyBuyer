<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Rates;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{
    
        /**
     * @Route("/", name="admin_dashboard")
     */
    public function WelcomeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
         return $this->render('admin/admin-dashboard.twig',array('users' => $users));
    }
}