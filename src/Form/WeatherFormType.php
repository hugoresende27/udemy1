<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class WeatherFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('latitude', NumberType::class, [
            'label' => 'Latitude',
            'scale' => 6, // Adjust scale as needed for your precision
        ])
        ->add('longitude', NumberType::class, [
            'label' => 'Longitude',
            'scale' => 6, // Adjust scale as needed for your precision
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Get Weather',
        ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
