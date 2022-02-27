<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class AskUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            -> add('recipient', EntityType::class,[
                'class'=>User::class ,
                'choice_label' => 'email'] )
            ->add('money', NumberType::class, [
                'label' => "Montant d'argent",
                'attr' => ['placeholder' => "Mettre l'argent"],
                'constraints' => [
                    new  Positive([
                        'message' => 'Attention le montant doit être au minimum de 1€'
                    ]),
                    new NotBlank([
                        'message' => 'Merci de donner un montant',
                    ]),
                ],
            ])
            ->add('text', TextType::class, [
                'label' => "Texte a envoyer a l'autre utilisateur",
                'attr' => ['placeholder' => "Texte a envoyer a l'autre utilisateur"],
                'constraints' => [
                    new  Length([
                        'min' => 6,
                        'message' => "Veuillez écrire un message de plus de 6 charactères"
                    ]),
                    new NotBlank([
                        'message' => 'Merci de mettre un texte',
                    ]),
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' =>  "Envoyer",
                'attr' => ['class' => 'btn my-[2rem] mx-auto hover:opacity-80']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
