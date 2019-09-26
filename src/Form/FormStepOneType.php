<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormStepOneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visitDate', DateType::class, [
            'label' => 'Date de visite',
            'required' => true
        ])
            ->add('visitType', ChoiceType::class,  [
                'choices'  => [
                    'Journée' => Booking::TYPE_DAY,
                    'Demi-journée' => Booking::TYPE_HALF_DAY,
                ],
                'label' => 'Type de visite',
            ])
            ->add('ticketNumber', ChoiceType::class,  [
                'choices'  => array_combine(range(1,Booking::MAX_TICKETS),(range(1,Booking::MAX_TICKETS))),
                'label' => 'Nombre de ticket',
            ])


        -> add ('email', EmailType::class, [
            'label' => 'Votre adresse mail'
        ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'validation_groups' => ['init']
        ]);
    }
}
