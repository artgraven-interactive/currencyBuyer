<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RatesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('currency', TextType::class,array('attr'=>array('class' => 'form-control',"readonly"=>true)))
                ->add('surcharge',TextType::class, array('attr' =>  array('class' => 'form-control')))
                ->add('exchange',TextType::class, array('attr' =>  array('class' => 'form-control ')))
                ->add('notify',CheckboxType::class, array('required' =>  false))
                ->add('discount',TextType::class, array('attr' =>  array('class' => 'form-control ')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rates'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_rates';
    }


}
