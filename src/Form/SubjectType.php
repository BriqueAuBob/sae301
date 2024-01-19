<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Subject;
use App\Repository\CourseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    private RequestStack $requestStack;

    private CourseRepository $courseRepository;

    public function __construct(RequestStack $requestStack, CourseRepository $courseRepository)
    {
        $this->requestStack = $requestStack;
        $this->courseRepository = $courseRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $id_course = $request->attributes->get('id_course');
        if ($id_course) {
            $course = $this->courseRepository->find($id_course);
        }

        $builder
            ->add('name_code')
            ->add('name')
            ->add('color', ColorType::class, [
                'attr' => [
                    'class' => 'w-full'
                ]
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name',
                'data' => $course ?? null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
