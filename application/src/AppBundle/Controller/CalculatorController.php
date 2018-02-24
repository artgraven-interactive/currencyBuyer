<?php

/* 
 * Created by Jacques Artgraven
 * 33a homestead, Rivonia
 * http://github.com/artgraven-interactive
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Calculator controller.
 *
 * @Route("calculator")
 */
class CalculatorController extends Controller
{   
    
     /**
     * @Route("/GetQuote", name="get_quote")
     * @Method({"GET", "POST"})
     */
      public function GetQuoteAction(Request $request)
    {
        // This method is specific to generating a quote by accepting an input number and a currency
          $action            = $request->request->get('action');
          $currency          = $request->request->get('rate');
          $amount            = $request->request->get('amount');
          
        //get the selected currency
            $em = $this->getDoctrine()->getManager();
            $currency = $em->getRepository('AppBundle:Rates')->find($currency);
        
        //process action  
          if($action == "currency-to"){
              $result = $this->CurrencyToUsdAction($currency,$amount);
          }else{
              $result = $this->CurrencyForUsdAction($currency,$amount);
          }
          
        //return result
            $serializer = $this->get('jms_serializer');
            $response   =     $serializer->serialize($result, 'json');
            return new Response($response);
    }
    

      private function CurrencyForUsdAction($currency,$amount)
    {
        // method to help us determine how much of a currency we can get for our usd amount
  
        $sum = ($currency->getExchange() * $amount);
        
        return $sum;
    }
    

      public function CurrencyToUsdAction($currency,$amount)
    {
          // method to help us determine how much the usd will be for a currency amount
          $sum = ($amount / $currency->getExchange());
        return $sum;
    }
    
}

