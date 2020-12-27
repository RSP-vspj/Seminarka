<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClanekType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aktivniClanek')
            ->add('clanekZobrazenRedakci')
            ->add('cekaNaStanoveniRecenzentu')
            ->add('jsouStanoveniRecenzenti')
            ->add('probihaRecenzniRizeni')
            ->add('recenzniRizeniByloDokonceno')
            ->add('recenzniRizeniByloZruseno')
            ->add('novePodanaRevize')
            ->add('clanekPrijat')
            ->add('clanekPrijatSVyhradami')
            ->add('clanekPrijatVyzadujeFormalniDoplneni')
            ->add('clanekZamitnutNeobstalVRecenznimRizeni')
            ->add('clanekZamitnutNesplnujeSablonu')
            ->add('clanekZamitnutTematickyNevhodny')
            ->add('cekaSeNaAutorovuRevizi')
            ->add('nutnostPredatNovouReviziZpetRecenzentum')
            ->add('pozadavekNaNahrazeniRevizeAutorem')
            ->add('lzePodatNovouRevizi')
            ->add('nejednoznacnostRecenznihoRizeni')
            ->add('clanekVydan')
            ->add('cisloCasopisu')
            ->add('neregistrovaniSpoluautori')
            ->add('tematickeZamereniSlovne')
            ->add('tematickeZamereni')
            ->add('nabidnoutZnovuOdmitnutyClanek')
            ->add('uzaverkaCislaCasopisu')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Clanek'
        ));
    }
}
