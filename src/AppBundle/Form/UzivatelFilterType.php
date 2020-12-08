<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class UzivatelFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('uzivatelAktivni', Filters\BooleanFilterType::class)
            ->add('jmeno', Filters\TextFilterType::class)
            ->add('prijmeni', Filters\TextFilterType::class)
            ->add('login', Filters\TextFilterType::class)
            ->add('heslo', Filters\TextFilterType::class)
            ->add('odbornost', Filters\TextFilterType::class)
            ->add('role', Filters\NumberFilterType::class)
        
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
