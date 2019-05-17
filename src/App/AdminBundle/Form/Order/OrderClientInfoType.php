<?php

namespace App\AdminBundle\Form\Order;

use App\AdminBundle\Entity\Order\OrderClientInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OrderClientInfoType
 * @package App\AdminBundle\Form\Order
 */
class OrderClientInfoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class)
            ->add('firstName', TextType::class)
            ->add('phoneNumber', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderClientInfo::class
        ]);
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return '';
    }

}