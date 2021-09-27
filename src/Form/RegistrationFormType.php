<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add ('prenom', TextType::class,[
                'label' => 'Prenom',
                'attr' => [
                     'placeholder' => 'Ajouter votre prénom ici...'
                ],
                'required' => false
            ])
            ->add ('nomDeFamille', TextType::class,[
                'label' => 'Nom de famille',
                'attr' => [
                     'placeholder' => 'Ajouter votre nom de famille ici...'
                ],
                'required' => false
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholer' => 'Ajouter votre email ici...'
                ],
                'required' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'veuillez accepter les CGUV',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les CGUV',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'invalid_message'=> 'Les mots de passe ne correspondent pas.',
                'first_options'=> [
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrez un mot de passe',
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'constraints'=> [
                        new NotBlank([
                            'message' => 'Vous devez entrez un mot de passe',
                        ]),
                    ],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
