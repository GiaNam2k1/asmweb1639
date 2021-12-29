<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class,
            [
                'label' => 'Course Category Name',
                'required' => true
            ])
            ->add('Description', TextType::class,
            [
                'label' => 'Desciption',
                'required' => false,
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 50
                ]
            ])
            ->add('Courses', EntityType::class,
            [
                'label' => 'Course',
                'required' => true,
                'class' => Course::class,
                'choice_label' => 'Name',
                'multiple' => false,
                'expanded' =>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseCategory::class
        ]);
    }
}
