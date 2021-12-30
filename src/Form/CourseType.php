<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CourseCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class,
            [
                'label' => 'Course name',
                'required' => true
            ])
            ->add('CourseID', IntegerType::class,
            [
                'label' => 'Course Id',
                'required' => true

            ])
            ->add('Description', TextType::class,
            [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 20
                ]
            ])
            ->add('courseCategory', EntityType::class,
            [
              
                'label' => 'Course Category',
                'required' => true,
                'class' => CourseCategory::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
