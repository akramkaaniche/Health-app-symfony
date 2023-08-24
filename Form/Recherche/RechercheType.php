<?php

namespace App\Form\Recherche;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;







class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inputRecherche',TextType::class)
            ->add('critere',ChoiceType::class,
                array('choices' => array(
                    'Nom' => 'nom',
                    'Prenom' => 'prenom',
                    'Adresse' => 'adresse'
                    )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
