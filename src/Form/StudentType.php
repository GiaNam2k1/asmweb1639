<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'label' => 'Student name',
                'required' => true
            ])
            
            ->add('birthday', DateType::class, 
            [
                'label' => 'Student birthday',
                'required' => true,
                'widget' => 'single_text'
            ])

            ->add('phone', IntegerType::class,
            [
                'label' => 'Phone',
                'required' => true,
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 10
                ]
            ])

            ->add('club', EntityType::class,
            [
                'label' => 'Club',
                'required' => true,
                'class' => Club::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('cover', FileType::class,
            [
                'label' => 'Cover',
                'data_class' => null,
                'required' => is_null($builder->getData()->getCover())
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class
        ]);
    }
}
