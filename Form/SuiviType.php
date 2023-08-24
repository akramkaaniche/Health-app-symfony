<?php

namespace App\Form;

use App\Entity\Objectif;
use App\Entity\Suivi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiviType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valeur', ChoiceType::class, [
                'choices' => [
                    '1'=> 1,
                    '2'=> 2,
                    '3'=> 3,
                    '4'=> 4,
                    '5'=> 5,
                    '6'=> 6,
                    '7'=> 7,
                    '8'=> 8,
                    '9'=> 9,
                    '10'=> 10,
                    '11'=> 11,
                    '12'=> 12,
                    '13'=> 13,
                    '14'=> 14,
                    '15'=> 15,
                    '16'=> 16,
                    '17'=> 17,
                    '18'=> 18,
                    '19'=> 19,
                    '20'=> 20,
                    '21'=> 21,
                    '22'=> 22,
                    '23'=> 23,
                    '24'=> 24,
                    '25'=> 25,
                    '26'=> 26,
                    '27'=> 27,
                    '28'=> 28,
                    '29'=> 29,
                    '30'=> 30,
                ]
            ])
            ->add('color', ColorType::class)
            ->add('date', null, [
                'label' => 'Date',
                'required' => false,
                'widget' => 'single_text',

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Suivi::class,
        ]);
    }
}
