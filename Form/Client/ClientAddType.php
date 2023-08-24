<?php

namespace App\Form\Client;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Gregwar\CaptchaBundle\Type\CaptchaType;







class ClientAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',TextType::class)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',TextType::class)

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les deux mot de passe ne correspond pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => ['label' => '.'],
                'second_options' => ['label' => '.'],
             ])
            ->add('tel',TextType::class)
            ->add('adresse', CheckboxType::class, [
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter .',
                    ]),
                ],

            ])
            ->add('specialite',TextType::class)

            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])

            ->add('captcha', CaptchaType::class,[

                    'invalid_message' => 'Code incorrect',

                ]

            );




        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
