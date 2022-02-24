<?php

namespace App\Form;

use App\Entity\Account;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class AddMoneyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('money', NumberType::class, [
                'label' => "Montant d'argent",
                'attr' => ['placeholder' => '200'],
                'invalid_message' => 'Votre monnaie actuelle est l\'euro. Merci de préciser un montant sans valeur de monnaie. Exemple : 15.',
                'constraints' => [
                    new  Positive([
                        'message' => 'Attention le montant doit être au minimum de 1€'
                    ]),
                    new NotBlank([
                        'message' => 'Merci de donner un montant',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' =>  "Ajouter",
                'attr' => ['class' => 'btn my-[2rem] mx-auto hover:opacity-80']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Account::class,
        ]);
    }
}
