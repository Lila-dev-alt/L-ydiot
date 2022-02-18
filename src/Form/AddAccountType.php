<?php

namespace App\Form;


use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          //  ->add('accountId')
            ->add('nomCompte', TextType::class,[
              'attr' => ['placeholder' => 'Cagnotte anniversaire'],
              'label' => 'Nom du compte',
          ])
            ->add('money', TextType::class,[
                'attr' => ['placeholder' => '200€'],
                'label' => 'Montant sur le compte',
                'empty_data' => '0'
            ])
          //  ->add('dateCreation')
          //  ->add('status')
          //  ->add('userId')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
