<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Subject;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\AdminUserEditType;
use App\Form\CourseType;
use App\Form\SubjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin', name: 'app_dashboard')]
    public function index(AuthorizationCheckerInterface $checker): Response
    {
        $currentUser = $this->getUser();

        if ($checker->isGranted('ROLE_MOD') && !$checker->isGranted('ROLE_ADMIN') && !$checker->isGranted('ROLE_SUPER_ADMIN')) {
            $group = $currentUser->getGroup();
            $ticketRepo = $this->em->getRepository(Ticket::class);
            $tickets = $ticketRepo->createQueryBuilder('t')
                ->leftJoin('t.homework', 'h')
                ->andWhere('h.group = :group')
                ->andWhere('t.status = 0')
                ->setParameter('group', $group)
                ->getQuery()
                ->getResult();
        } else {
            $tickets = $this->em->getRepository(Ticket::class)->findBy(['status' => 0], ['status' => 'ASC', 'id' => 'DESC']);
        }

        return $this->render('admin/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Gestion des utilisateurs
     * @return Response
     */
    #[Route('/admin/users', name: 'app_dashboard_users')]
    public function viewUsers(): Response
    {
        $users = $this->em->getRepository(User::class)->findAll();
        return $this->render('admin/users/users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/user/edit/{id}', name: 'app_dashboard_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function viewUser(Request $request, int $id): Response
    {
        $user = $this->em->getRepository(User::class)->find($id);

        if (!$user) {
            $this->addFlash('danger', 'L\'utilisateur n\'existe pas !');
            return $this->redirectToRoute('app_dashboard_users');
        }

        $form = $this->createForm(AdminUserEditType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur <b>' . $user->getName() . '</b> a bien été modifié !');
            return $this->redirectToRoute('app_dashboard_users');
        }

        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'app_dashboard_user_delete', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteUser(User $user): Response
    {
        $this->em->remove($user);
        $this->em->flush();

        $this->addFlash('success', 'L\'utilisateur <b>' . $user->getName() . '</b> a bien été supprimé !');
        return $this->redirectToRoute('app_dashboard_users');
    }

    /**
     * Gestion des départements
     * @return Response
     */
    #[Route('/admin/courses', name: 'app_dashboard_courses')]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function viewCourses(): Response
    {
        $courses = $this->em->getRepository(Course::class)->findAll();

        return $this->render('admin/courses/index.html.twig', [
            'courses' => $courses
        ]);
    }

    #[Route('/admin/course/{id}', name: 'app_dashboard_course_form', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function formCourse(Request $request, int $id = null): Response
    {
        if ($id) {
            $course = $this->em->getRepository(Course::class)->find($id);
            $subjects = $course->getSubjects();
        } else {
            $course = new Course();
        }

        $form = $this->createForm(CourseType::class, $course)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $this->em->persist($course);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard_courses');
        }

        return $this->render('admin/courses/form.html.twig', [
            'course' => $course,
            'form' => $form,
            'subjects' => $subjects ?? null
        ]);
    }

    #[Route('/admin/course/delete/{id}', name: 'app_dashboard_course_delete', methods: ['GET'])]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function deleteCourse(Course $course): Response
    {
        $this->em->remove($course);
        $this->em->flush();

        $this->addFlash('success', 'Le département <b>' . $course->getName() . '</b> a bien été supprimée !');
        return $this->redirectToRoute('app_dashboard_courses');
    }

    /**
     * Gestion des matières
     * @param Request $request
     * @param int|null $id_course
     * @param int|null $id
     * @return Response
     */
    #[Route('/admin/course/{id_course}/subject/{id}', name: 'app_dashboard_subject_form', requirements: ['id' => '\d+', 'id_course' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function editSubject(Request $request, int $id_course = null, int $id = null): Response
    {
        if ($id) {
            $subject = $this->em->getRepository(Subject::class)->find($id);
        } else {
            $subject = new Subject();
        }

        $form = $this->createForm(SubjectType::class, $subject)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subject->setColor(substr($subject->getColor(), 1));
            $form->getData();
            $this->em->persist($subject);
            $this->em->flush();
            return $this->redirectToRoute('app_dashboard_course_form', ['id_course' => $subject->getCourse()->getId()]);
        }

        return $this->render('admin/courses/subject/form.html.twig', [
            'subject' => $subject,
            'form' => $form
        ]);
    }

    #[Route('/admin/course/subject/delete/{id}', name: 'app_dashboard_subject_delete', methods: ['GET'])]
    #[IsGranted("ROLE_SUPER_ADMIN")]
    public function deleteSubject(Subject $subject): Response
    {
        $this->em->remove($subject);
        $this->em->flush();

        $this->addFlash('success', 'La matière <b>' . $subject->getName() . '</b> a bien été supprimée !');
        return $this->redirectToRoute('app_dashboard_course_form', ['id' => $subject->getCourse()->getId()]);
    }
}
