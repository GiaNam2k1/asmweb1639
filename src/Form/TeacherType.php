<?php

namespace App\Form;

use App\Entity\Teacher;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class, 
        [
            'label' =>'Full Name',
            'required'=> true,
            'attr'=>[
                'minlength'=> 5,
                'maxlength'=>30
            ]
        ])
        ->add('dob', DateType::class,[
            'label' =>"Date of birth",
            'required'=> true,
            'widget'=>'single_text'
        ])
        ->add('email',TextType::class, 
        [
            'label' =>'Email',
            'required'=> true,
            'attr' =>[
                'minlength' =>5,
                'maxlength'=>35
            ]
        ])
        ->add('phone',NumberType::class,
        [
            'label' =>'Phone Number',
            'required'=> true,
            'attr'=>[
                'minlength'=> 10,
                'maxlength' =>10
            ]
        ])
        ->add('address', TextType::class,
        [
            'label' =>'Address',
            'required'=> true,
            'attr' =>[
                'minlength' =>5,
                'maxlength'=>35
            ]
        ])
        ->add('image',FileType::class,
        [
            'label' => 'Image',
            'data_class' => null,
            'required' => is_null ($builder->getData()->getImage()) 
        ])
        ->add('city',ChoiceType::class,
        [
            'label' => 'City',
            'required' => true,
            'choices'=>[
                'Ha Noi'=>'Ha Noi',
                'Da Nang'=>'Da Nang',
                'HCM'=>'HCM'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
