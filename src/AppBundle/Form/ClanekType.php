<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ClanekType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('jmenoClanku')
            ->add('neregistrovaniSpoluautori')
            // https://symfony.com/doc/3.4/controller/upload_file.html
            ->add('clanekSoubor', FileType::class, [
                'label' => 'Článek (PDF nebo doc(x))',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                // Uprav pole na povinne (predchozi dva radky proto ignoruj)
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF or doc(x) document',
                    ])
                ],
            ])
        ;

//        $builder
//            ->add('aktivniClanek')
//            ->add('clanekZobrazenRedakci')
//            ->add('cekaNaStanoveniRecenzentu')
//            ->add('jsouStanoveniRecenzenti')
//            ->add('probihaRecenzniRizeni')
//            ->add('recenzniRizeniByloDokonceno')
//            ->add('recenzniRizeniByloZruseno')
//            ->add('novePodanaRevize')
//            ->add('clanekPrijat')
//            ->add('clanekPrijatSVyhradami')
//            ->add('clanekPrijatVyzadujeFormalniDoplneni')
//            ->add('clanekZamitnutNeobstalVRecenznimRizeni')
//            ->add('clanekZamitnutNesplnujeSablonu')
//            ->add('clanekZamitnutTematickyNevhodny')
//            ->add('cekaSeNaAutorovuRevizi')
//            ->add('nutnostPredatNovouReviziZpetRecenzentum')
//            ->add('pozadavekNaNahrazeniRevizeAutorem')
//            ->add('lzePodatNovouRevizi')
//            ->add('nejednoznacnostRecenznihoRizeni')
//            ->add('clanekVydan')
//            ->add('cisloCasopisu')
//            ->add('neregistrovaniSpoluautori')
//            ->add('tematickeZamereniSlovne')
//            ->add('tematickeZamereni')
//            ->add('nabidnoutZnovuOdmitnutyClanek')
//            ->add('uzaverkaCislaCasopisu')
//        ;

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
