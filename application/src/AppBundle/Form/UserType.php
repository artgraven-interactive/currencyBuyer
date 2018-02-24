<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('surname',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('cellphone',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('title',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('address',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('credit',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('currency',TextType::class, array('attr' =>  array('class' => 'form-control')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
