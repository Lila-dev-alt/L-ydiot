<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class SelectAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compte', EntityType::class, [
                'choices' => $options['accounts'],
                'class' => Account::class,
                'constraints' => [
                    new  Positive([
                        'message' => 'Attention le montant doit être au minimum de 1€'
                    ])
                ],
            ])
        ->add('submit', SubmitType::class, [
        'label' =>  "Accepter",
        'attr' => ['class' => 'btn my-[2rem] mx-auto hover:opacity-80']])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'accounts' => []
        ]);
    }
}
