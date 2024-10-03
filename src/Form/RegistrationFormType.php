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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countries = Countries::getNames('fr');
        $builder
            
            ->add('lastname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'NOM'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank(),
                ]
            ])
            ->add('firstname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank(),
                ]
            ])
            ->add('email', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse email'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank(),
                    new Assert\Email()
                ]
            ])
            ->add('pseudo', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Pseudo'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank(),
                ]

            ])
            ->add('address', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'N° et rue'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank(),
                ]
            ])
            ->add('zipcode', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code Postale'],
                'constraints' => [
                    new Assert\Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('city', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ville'],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank(),
                ]
            ])
            ->add('country', ChoiceType::class,[
                'label' => 'Pays',
                'choices' => array_flip($countries),
                'placeholder' => 'Selectionnez votre pays',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('avatar', FileType::class,[
                'label' => 'Avatar',
                'mapped' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/', 
                    message: "Le mot de passe doit contenir 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et au moins 1 caractère spécial.")
                ],
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
