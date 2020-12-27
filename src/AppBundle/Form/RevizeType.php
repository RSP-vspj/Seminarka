<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RevizeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('clanekID')
            ->add('jmenoClanku')
            ->add('cestaKSouboru')
            ->add('komentarAutoru')
            ->add('komentarRedaktora')
            ->add('sdeleniAdmin')
            ->add('ostatniSdeleni')
            ->add('datumPridaniClanku')
            ->add('uzaverkaRecenznihoRizeni')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Revize'
        ));
    }
}
