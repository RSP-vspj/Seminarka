<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class RecenzentiFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('uzivatelID', Filters\NumberFilterType::class)
            ->add('clanekID', Filters\NumberFilterType::class)
            ->add('cisloRevize', Filters\NumberFilterType::class)
            ->add('pozadavekNaRecenziZobrazen', Filters\BooleanFilterType::class)
            ->add('pozadavekNaRecenziPrijat', Filters\BooleanFilterType::class)
            ->add('pozadavekNaRecenziOdmitnut', Filters\BooleanFilterType::class)
            ->add('recenzeJeDokoncena', Filters\BooleanFilterType::class)
            ->add('hodnoceniClankuSlovni', Filters\TextFilterType::class)
            ->add('hodnoceniClankuPrinos', Filters\NumberFilterType::class)
            ->add('hodnoceniClankuOriginalita', Filters\NumberFilterType::class)
            ->add('hodnoceniClankuOdbornost', Filters\NumberFilterType::class)
            ->add('hodnoceniClankuJazyk', Filters\NumberFilterType::class)
            ->add('datumOdevzdaniRecenze', Filters\DateFilterType::class)
        
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
