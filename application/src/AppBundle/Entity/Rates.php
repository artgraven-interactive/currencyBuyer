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
 * @ORM\Table(name="rates")
 */
class Rates 
{
    //columns
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", name="currency") 
     */
    protected $currency;
    
    /**
     * @ORM\Column(type="float", name="surcharge") 
     */
    protected $surcharge;
    
    /**
     * @ORM\Column(type="float", name="exchange") 
     */
    protected $exchange;
    
    /**
     * @ORM\Column(type="datetime", name="CheckDate") 
     */
    protected $checkDate;
    
    /**
     * @ORM\Column(type="boolean", name="notify", nullable=true) 
     */
    protected $notify;
    
    /**
     * @ORM\Column(type="integer", name="discount") 
     */
    protected $discount;
    
    
    //getters
    function getId() {
        return $this->id;
    }

    function getCurrency() {
        return $this->currency;
    }

    function getSurcharge() {
        return $this->surcharge;
    }

    function getExchange() {
        return $this->exchange;
    }

    function getCheckDate() {
        return $this->checkDate;
    }

    function getNotify() {
        return $this->notify;
    }

    function getDiscount() {
        return $this->discount;
    }

    function setId($id) {
        $this->id = $id;
    }

    
    //setters
    function setCurrency($currency) {
        $this->currency = $currency;
    }

    function setSurcharge($surcharge) {
        $this->surcharge = $surcharge;
    }

    function setExchange($exchange) {
        $this->exchange = $exchange;
    }

    function setCheckDate($checkDate) {
        $this->checkDate = new DateTime('now');;
    }

    function setNotify($notify) {
        $this->notify = $notify;
    }

    function setDiscount($discount) {
        $this->discount = $discount;
    }


}