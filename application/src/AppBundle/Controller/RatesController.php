<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rates;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rate controller.
 *
 * @Route("rates")
 */
class RatesController extends Controller
{
    
     /**
     * Call Api to update the rates table
     *
     * @Route("/updateRates", name="rates_update_records")
      * @Method("GET")
     */
    public function UpdateRecordAction(Request $request)
    {
        
        $getRates = $this->api("&format=1");
        if(!empty($getRates)){
            $em = $this->getDoctrine()->getManager();
        foreach($getRates->quotes as $quote=>$quoteValue){
            $rate = $em->getRepository('AppBundle:Rates')->findby(array("currency"=>$quote));
            if($rate == null){
                $rate = new Rates();
                $rate->setSurcharge(0);
                $rate->setCurrency($quote);
                $rate->setNotify(false);
                $rate->setDiscount(0);
            }else{
                $rate = (object)$rate[0];
            }
            $rate->setCheckDate('now');
            $rate->setExchange($quoteValue);
            $em->persist($rate);
        }
        $em->flush();
        $status = true;
        }else{
        $status = false;   
        }
        
            $serializer = $this->get('jms_serializer');
            $response   =     $serializer->serialize($status, 'json');
            return new Response($response);
    }
    
    /**
     * Lists all rate entities.
     *
     * @Route("/", name="rates_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rates = $em->getRepository('AppBundle:Rates')->findAll();

        return $this->render('rates/index.html.twig', array(
            'rates' => $rates,
        ));
    }

    /**
     * Finds and displays a rate entity.
     *
     * @Route("/{id}", name="rates_show")
     * @Method("GET")
     */
    public function showAction(Rates $rate)
    {
        $deleteForm = $this->createDeleteForm($rate);

        return $this->render('rates/show.html.twig', array(
            'rate' => $rate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rate entity.
     *
     * @Route("/{id}/edit/admin/", name="rates_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rates $rate)
    {
        $deleteForm = $this->createDeleteForm($rate);
        $editForm = $this->createForm('AppBundle\Form\RatesType', $rate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rates_edit', array('id' => $rate->getId()));
        }

        return $this->render('rates/edit.html.twig', array(
            'rate' => $rate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rate entity.
     *
     * @Route("/{id}", name="rates_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rates $rate)
    {
        $form = $this->createDeleteForm($rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rate);
            $em->flush();
        }

        return $this->redirectToRoute('rates_index');
    }

    /**
     * Creates a form to delete a rate entity.
     *
     * @param Rates $rate The rate entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Rates $rate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rates_delete', array('id' => $rate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    private function api($paramaters){
       // as this is a very basic api i decided to simply use curl to handle the calls as no real authentication was required other than passing in the access key
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.apilayer.net/api/live?access_key=cb62ab7fe2b1cfc2651b2f7291a0a9ff".$paramaters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $obj = json_decode($output);
        curl_close($ch); 
        
        return $obj;
    }
   
    
}
