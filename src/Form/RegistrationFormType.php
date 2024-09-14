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
use Symfony\Component\Intl\Countries;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countries = Countries::getNames('fr');
        $builder
            
            ->add('lastname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'NOM']
            ])
            ->add('firstname', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom']
            ])
            ->add('email', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Adresse email']
            ])
            ->add('pseudo', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Pseudo']
            ])
            ->add('address', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'N° et rue']
            ])
            ->add('zipcode', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code Postale']
            ])
            ->add('city', TextType::class,[
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ville']
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
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
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
