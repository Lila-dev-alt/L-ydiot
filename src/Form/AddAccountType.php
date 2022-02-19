<?php

namespace App\Form;


use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class AddAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          //  ->add('accountId')
            ->add('nomCompte', TextType::class,[
              'attr' => ['placeholder' => 'Cagnotte anniversaire'],
              'label' => 'Nom du compte',
              'constraints' => [
              new NotBlank([
                  'message' => 'Merci de remplir ce champ',
              ]),
              new  Length([
                  'min' => 1,
                  'minMessage' => 'Attention le champ doit contenir au moins 1 charactère'
              ]),
              ],
          ])
            ->add('money', TextType::class,[
                'attr' => ['placeholder' => '200'],
                'label' => 'Montant sur le compte',
                 'constraints' => [
                    new  Positive([
                        'message' => 'Attention le montant doit être au minimum de 1€'
                    ]),
                     new NotBlank([
                         'message' => 'Merci de remplir ce champ',
                     ]),
                    ],
            ])
          //  ->add('dateCreation')
          //  ->add('status')
          //  ->add('userId')
            ->add('submit', SubmitType::class , [
                'label' =>  "Créer mon compte",
                 'attr' => ['class' => 'btn my-[2rem] mx-auto hover:opacity-80']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
