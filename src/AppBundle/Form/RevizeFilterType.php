<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class RevizeFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('clanekID', Filters\NumberFilterType::class)
            ->add('jmenoClanku', Filters\TextFilterType::class)
            ->add('cestaKSouboru', Filters\TextFilterType::class)
            ->add('komentarAutoru', Filters\TextFilterType::class)
            ->add('komentarRedaktora', Filters\TextFilterType::class)
            ->add('sdeleniAdmin', Filters\TextFilterType::class)
            ->add('ostatniSdeleni', Filters\TextFilterType::class)
            ->add('datumPridaniClanku', Filters\DateFilterType::class)
            ->add('uzaverkaRecenznihoRizeni', Filters\DateFilterType::class)
        
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
