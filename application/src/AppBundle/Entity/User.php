<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    //columns
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", name="name", nullable=true) 
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", name="surname", nullable=true)
     */
    protected $surname;
    
    /**
     * @ORM\Column(type="string", name="cellphone", nullable=true)
     */
    protected $cellphone;
    
    /**
     * @ORM\Column(type="string", name="title", nullable=true)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", name="address", nullable=true)
     */
    protected $address;
    
    /**
     * @ORM\Column(type="integer", name="credit", nullable=true)
     */
    protected $credit;
    
    
    /**
     * @ORM\Column(type="string", name="currency", nullable=true)
     */
    protected $currency;
    
    
    //getters
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getCellphone() {
        return $this->cellphone;
    }

    function getTitle() {
        return $this->title;
    }

    function getAddress() {
        return $this->address;
    }

    function getCredit() {
        return $this->credit;
    }

    function getCurrency() {
        return $this->currency;
    }

    //setters
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setCellphone($cellphone) {
        $this->cellphone = $cellphone;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setCredit($credit) {
        $this->credit = $credit;
    }

    function setCurrency($currency) {
        $this->currency = $currency;
    }



}