<?php

namespace App\Form;

use Assert\Length;
use App\Entity\Contact;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre NOM'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre Prénom'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre adresse mail'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 180]),
                    new Assert\NotBlank(),
                    new Assert\Email()
                ]
            ])
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sujet de votre message'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre message'
                ],
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-md submitBtn'
                ],
                'label' => 'Envoyer ma demande'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
