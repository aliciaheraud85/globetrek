<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countries = Countries::getNames('fr');
        $builder
            
            ->add('lastname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'NOM'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100])
                ]
            ])
            ->add('firstname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100])
                ]
            ])
            ->add('email', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse email'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\Email()
                ]
            ])
            ->add('pseudo', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Pseudo'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100])
                ]
            ])
            ->add('address', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'N° et rue'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                ]
            ])
            ->add('zipcode', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code Postale'],
                'constraints' => [
                    new Assert\Length(['min' => 5]),
                    new Assert\Type('integer')
                ]
            ])
            ->add('city', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ville'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ]
            ])
            ->add('country', ChoiceType::class,[
                'label' => 'Pays',
                'choices' => array_flip($countries),
                'placeholder' => 'Selectionnez votre pays'
            ])
            ->add('avatar', FileType::class,[
                'label' => 'Avatar',
                'required' => false,
                'mapped' => false
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-md submitBtn'
                ],
                'label' => 'Enregistrer'
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
