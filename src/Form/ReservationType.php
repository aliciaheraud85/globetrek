<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Travels;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('date', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control mb-4',
                    
                ],
                'label' => 'Date de départ',
                'placeholder' => 'Choisissez votre date de départ',
                'choices' => [
                    $options['travelPost']->getDate1()->format('d/m/Y') => $options['travelPost']->getDate1(),
                    $options['travelPost']->getDate2()->format('d/m/Y') => $options['travelPost']->getDate2(),
                    $options['travelPost']->getDate3()->format('d/m/Y') => $options['travelPost']->getDate3(),
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [ 'class' => 'btn btn-md submitBtn'],
                'label' => 'J\'envoie ma demande'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'travelPost' => null,
        ]);
    }
}
