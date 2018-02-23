<?php

/* 
 * Created by Jacques Artgraven
 * 33a homestead, Rivonia
 * http://github.com/artgraven-interactive
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Datetime;
/**
 * @ORM\Entity
 * @ORM\Table(name="history")
 */
class History 
{
    //columns
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $Id;
    
    /**
     * @ORM\Column(type="datetime", name="TransactionDate") 
     */
    protected $TransactionDate;
    
     /**
     * @ORM\Column(type="string", name="Currency") 
     */
    protected $Currency;
    
    /**
     * @ORM\Column(type="float", name="Rate") 
     */
    protected $Rate;
    
    /**
     * @ORM\Column(type="float", name="Surcharge") 
     */
    protected $Surchage;
    
    /**
     * @ORM\Column(type="integer", name="AmountPurchased") 
     */
    protected $AmountPurchased;
    
    /**
     * @ORM\Column(type="integer", name="AmountPaid") 
     */
    protected $AmountPaid;
    
    
    /**      
      * @ORM\ManyToOne(targetEntity="User", inversedBy="id")      
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")      
      */ 
    protected $user;
    
    /**
     * @ORM\Column(type="boolean", name="TransactionStatus") 
     */
    protected $TransactionStatus;
    
    function getId() {
        return $this->Id;
    }

    function getTransactionDate() {
        return $this->TransactionDate;
    }

    function getCurrency() {
        return $this->Currency;
    }

    function getRate() {
        return $this->Rate;
    }

    function getSurchage() {
        return $this->Surchage;
    }

    function getAmountPurchased() {
        return $this->AmountPurchased;
    }

    function getAmountPaid() {
        return $this->AmountPaid;
    }

    function getUser() {
        return $this->user;
    }

    function getTransactionStatus() {
        return $this->TransactionStatus;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setTransactionDate($TransactionDate) { 
        $this->TransactionDate = new DateTime('now');
    }

    function setCurrency($Currency) {
        $this->Currency = $Currency;
    }

    function setRate($Rate) {
        $this->Rate = $Rate;
    }

    function setSurchage($Surchage) {
        $this->Surchage = $Surchage;
    }

    function setAmountPurchased($AmountPurchased) {
        $this->AmountPurchased = $AmountPurchased;
    }

    function setAmountPaid($AmountPaid) {
        $this->AmountPaid = $AmountPaid;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setTransactionStatus($TransactionStatus) {
        $this->TransactionStatus = $TransactionStatus;
    }


}
    
