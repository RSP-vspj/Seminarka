<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class AutoriFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('uzivatelID', Filters\NumberFilterType::class)
            ->add('clanekID', Filters\NumberFilterType::class)
            ->add('cisloRevize', Filters\NumberFilterType::class)
            ->add('pripominkyAutoraKRevizi', Filters\TextFilterType::class)
            ->add('vyjadreniAutoraKVysledkuRecenznihoRizeni', Filters\TextFilterType::class)
            ->add('autorPrihlasenOdPridaniNejnovejsiRecenze', Filters\BooleanFilterType::class)
            ->add('autorSeznamenSVysledkyRecenznihoRizeni', Filters\BooleanFilterType::class)
        
        ;
        $builder->setMethod("GET");


    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
