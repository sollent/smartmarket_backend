<?php

namespace App\AdminBundle\Form\Order;

use App\AdminBundle\Entity\Order\OrderLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OrderLocationForm
 * @package App\AdminBundle\Form\Order
 */
class OrderLocationForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locationType', TextType::class)
            ->add('city', TextType::class)
            ->add('street', TextType::class)
            ->add('postIndex', IntegerType::class)
            ->add('homeNumber', IntegerType::class)
            ->add('apartmentNumber', IntegerType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderLocation::class
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