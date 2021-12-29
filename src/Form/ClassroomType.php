<?php

namespace App\Form;

use App\Entity\Teacher;
use App\Entity\Classroom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('course',TextType::class,
            [
                'label' => 'Course Name',
                'required'=> true,
                'attr'=>[
                    'minlength'=>5,
                    'maxlength'=>35
                ]
            ])
            ->add('classname',TextType::class,
            [
                'label'=>'Name of class',
                'required'=> true,
                'attr'=>[
                    'minlength'=>5,
                    'maxlength'=>10
                ]
            ])
            ->add('teachers', EntityType::class,
            [
                'label'=> 'Choice teacher',
                'required'=>true,
                'class'=>Teacher::class,
                'choice_label'=> "name",
                'multiple'=>true,
                'expanded'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
