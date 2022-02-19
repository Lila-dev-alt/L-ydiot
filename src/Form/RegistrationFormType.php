<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('surname', TextType::class, [
                'attr' => ['placeholder' => 'Prénom'],
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre Prénom',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Nom'],
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre Nom de Famille',
                    ]),
                ],
            ])
            ->add('email', TextType::class, [
                'attr' => ['placeholder' => 'E-mail'],
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre email',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => ['placeholder' => 'J’ai lu et accepte la politique de confidentialité sur les données personnelles de ce site.'],
                'label' => 'J’ai lu et accepte la politique de confidentialité sur les données personnelles de ce site.',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez acceptez les termes d\'utilisation.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les deux champs mot de passe ne correspondent pas.',
                'constraints' => [
                    new NotBlank([
                        'message' => 'entrez votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères minimum',
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => 'Répétez mot de passe', 'attr' => ['placeholder' => 'Répétez mot de passe']],
            ])
            ->add('submit', SubmitType::class, [
                    'label' =>  "S'inscrire",
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
