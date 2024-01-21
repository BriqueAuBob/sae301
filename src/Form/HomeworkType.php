<?php

namespace App\Form;

use App\Entity\Homework;
use App\Entity\Subject;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class HomeworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('year')
//            ->add('group')
            ->add('name', TextType::class, [
                'label' => 'Titre du rendu (requis)',
                'attr' => [
                    'placeholder' => 'Ex: SAE 301...',
                ],
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Ex: Rendu de la matière SAE 301...',
                ],
                'required' => false,
            ])
            ->add('teacher', TextType::class, [
                'label' => 'Enseignant (requis)',
                'attr' => [
                    'placeholder' => 'Ex: M. Dupont',
                ],
                'required' => true,
            ])
            ->add('platform', TextType::class, [
                'label' => 'Où déposer ? (requis)',
                'attr' => [
                    'placeholder' => 'Ex: Moodle, Teams, Discord...',
                ],
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' =>  [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ]
            ])
            ->add('due_date', DateTimeType::class, [
                'label' => 'Date de rendu (requis)',
                'widget' => 'single_text',
            ])
//            ->add('created_at')
            ->add('subject', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Homework::class,
        ]);
    }
}
