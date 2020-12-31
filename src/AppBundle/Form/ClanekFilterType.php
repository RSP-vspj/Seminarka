<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class ClanekFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('uzivatel', Filters\TextFilterType::class)
            ->add('aktivniClanek', Filters\BooleanFilterType::class)
            ->add('clanekZobrazenRedakci', Filters\BooleanFilterType::class)
            ->add('cekaNaStanoveniRecenzentu', Filters\BooleanFilterType::class)
            ->add('jsouStanoveniRecenzenti', Filters\BooleanFilterType::class)
            ->add('probihaRecenzniRizeni', Filters\BooleanFilterType::class)
            ->add('recenzniRizeniByloDokonceno', Filters\BooleanFilterType::class)
            ->add('recenzniRizeniByloZruseno', Filters\BooleanFilterType::class)
            ->add('novePodanaRevize', Filters\BooleanFilterType::class)
            ->add('clanekPrijat', Filters\BooleanFilterType::class)
            ->add('clanekPrijatSVyhradami', Filters\BooleanFilterType::class)
            ->add('clanekPrijatVyzadujeFormalniDoplneni', Filters\BooleanFilterType::class)
            ->add('clanekZamitnutNeobstalVRecenznimRizeni', Filters\BooleanFilterType::class)
            ->add('clanekZamitnutNesplnujeSablonu', Filters\BooleanFilterType::class)
            ->add('clanekZamitnutTematickyNevhodny', Filters\BooleanFilterType::class)
            ->add('cekaSeNaAutorovuRevizi', Filters\BooleanFilterType::class)
            ->add('nutnostPredatNovouReviziZpetRecenzentum', Filters\BooleanFilterType::class)
            ->add('pozadavekNaNahrazeniRevizeAutorem', Filters\BooleanFilterType::class)
            ->add('lzePodatNovouRevizi', Filters\BooleanFilterType::class)
            ->add('nejednoznacnostRecenznihoRizeni', Filters\BooleanFilterType::class)
            ->add('clanekVydan', Filters\BooleanFilterType::class)
            ->add('cisloCasopisu', Filters\TextFilterType::class)
            ->add('neregistrovaniSpoluautori', Filters\TextFilterType::class)
            ->add('tematickeZamereniSlovne', Filters\TextFilterType::class)
            ->add('tematickeZamereni', Filters\NumberFilterType::class)
            ->add('nabidnoutZnovuOdmitnutyClanek', Filters\DateFilterType::class)
            ->add('uzaverkaCislaCasopisu', Filters\DateFilterType::class)
            ->add('jmenoClanku', Filters\TextFilterType::class)
            ->add('cestaKsouboru', Filters\TextFilterType::class)
        
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
