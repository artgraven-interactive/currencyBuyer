<?php

/* 
 * Created by Jacques Artgraven
 * 33a homestead, Rivonia
 * http://github.com/artgraven-interactive
 */

namespace AppBundle\Controller;

use AppBundle\Entity\History;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rate controller.
 *
 * @Route("transaction")
 */
class TransactionController extends Controller
{
   /**
     * @Route("/", name="get_transaction")
    * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        // here we get the current transactions of the user if its a regular user or all if its admin
         $auth_checker = $this->get('security.authorization_checker');
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();
        
        $em = $this->getDoctrine()->getManager();
        if($auth_checker->isGranted('ROLE_ADMIN') ){
               $transactions = $em->getRepository('AppBundle:History')->findAll();
        }else{
            $transactions = $em->getRepository('AppBundle:History')->findByUser($user);
        }
        return $this->render('transaction/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'transactions' => $transactions
        ]);
    }
    
   
    
    /**
     * @Route("/ProcessTransaction", name="process_transaction")
     * @Method({"GET", "POST"})
     */
      public function ProcessTransactionAction(Request $request)
    {
          $choice            = $request->request->get('choice');
          $currency          = $request->request->get('currency');
          $amount            = $request->request->get('charge');
          $AmountPurchased   = $request->request->get('purchased');
          
          //get logged in user
          $auth_checker = $this->get('security.authorization_checker');
          $token = $this->get('security.token_storage')->getToken();
          $user = $token->getUser();
          
          //get the selected currency
            $em = $this->getDoctrine()->getManager();
            $currency = $em->getRepository('AppBundle:Rates')->findById($currency);
            $currency = (object)$currency[0];
            
        // if they have enough funds we can go ahead and process the transaction  
            $needle =  $this->CheckoutRun($currency,$amount);
   
            if($needle['status'] == true){
            //next lets store the transaction
            $transaction = new History();
            $transaction->setAmountPaid($needle['amount']);
            $transaction->setAmountPurchased($AmountPurchased);
            $transaction->setCurrency($currency->getCurrency());
            $transaction->setRate($currency->getExchange());
            $transaction->setSurchage($currency->getSurcharge());
            $transaction->setTransactionDate('now');
            $transaction->setTransactionStatus(true);
            $transaction->setUser($user);
            $em->persist($transaction);
            $em->flush();
            }
            
            //send email confirmation if required
           if($currency->getNotify() == true){
               //if you are having issues sending mail from local using this service
               // insure you have a cert installed and try again
               // also email must be a valid email or we will also fail and we arent currently handling for such failures which one would do it a real application
                $this->SendEmail($transaction,$user);
           }
          
            $serializer = $this->get('jms_serializer');
            $response   =     $serializer->serialize($transaction, 'json');
            return new Response($response);
    }
    
     /**
     * @Route("/{id}", name="show_invoice_transaction")
     * @Method({"GET", "POST"})
     */
    public function showTransactionAction(History $history){
        
         return $this->render('transaction/result.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
             'transaction' => $history
        ]);
    }
    
    private function CheckoutRun($currency,$amount){
        // here we look at the currency rules and apply them to the transaction
        
        //process a discount and deduct the funds from wallet
         $amount = $this->ProcessFees($amount,$currency);
            
        //if all went well. lets return the transaction object if it didnt lets return an error
            $needle['status'] = true;
            $needle['amount'] = $amount;
        return $needle;
    }
    
    
    private function SendEmail($transaction,$user){
        //a function used to send a confirmation of the transaction to the user
             $message = \Swift_Message::newInstance()
                    ->setSubject('Mukuru Tax Invoice')
                    ->setFrom('noreply@sinappsus.net')
                    ->setTo($user->getEmail())
                    ->setBody( $this->render('email/confirmation.twig',[ 'transaction' => $transaction]), 'text/html');
             
             if($this->container->get('mailer')->send($message)){
        return true;
             }else{return false;}
    }
    
    private function ProcessFees($amount,$currency){
        //a function used to process discounts based on the discount at the current rate

        //first we add the surcharge
       if($currency->getSurcharge() !== 0){
           
       }
        
        //next we reduce by the discount if any
        if($currency->getDiscount() !== 0){
        //turn rate into a decimal
            $discount = ($currency->getDiscount()/100);
            $increase = ($discount*$currency->getExchange());
            $amount = ($amount - $increase);
        }
        
       $this->updateUserWallet($amount);
        
        return $amount;
    }
    
    private function updateUserWallet($amount){
         //now deduct this amount from the buyers wallet
         //lets make sure its the same user and they are still logged in
            $userManager = $this->container->get('fos_user.user_manager');
            $auth_checker = $this->get('security.authorization_checker');
            $token = $this->get('security.token_storage')->getToken();
            $user = $token->getUser();
        
         // $user = $userManager->findUserBy(array('id'=>$user));
            $hasCred = $user->getCredit();
            $newCredit = $hasCred - $amount;
            $user->setCredit($newCredit);
            $thedata = $userManager->updateUser($user, true);
            
             return true;
             
    }
}
