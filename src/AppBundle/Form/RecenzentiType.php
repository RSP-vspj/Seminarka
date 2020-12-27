<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecenzentiType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uzivatelID')
            ->add('clanekID')
            ->add('cisloRevize')
            ->add('pozadavekNaRecenziZobrazen')
            ->add('pozadavekNaRecenziPrijat')
            ->add('pozadavekNaRecenziOdmitnut')
            ->add('recenzeJeDokoncena')
            ->add('hodnoceniClankuSlovni')
            ->add('hodnoceniClankuPrinos')
            ->add('hodnoceniClankuOriginalita')
            ->add('hodnoceniClankuOdbornost')
            ->add('hodnoceniClankuJazyk')
            ->add('datumOdevzdaniRecenze')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recenzenti'
        ));
    }
}
