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

class DashboardController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin', name: 'app_dashboard')]
    public function index(): Response
    {
        $tickets = $this->em->getRepository(Ticket::class)->findBy(['status' => 0]);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'DashboardController',
            'tickets' => $tickets
        ]);
    }

    /**
     * Gestion des tickets
     * @param Ticket $ticket
     * @return Response
     */
    #[Route('/admin/ticket/{id}', name: 'app_dashboard_ticket')]
    public function viewTicketsDashboard(Ticket $ticket): Response
    {
        return $this->render('admin/ticket.html.twig', [
            'ticket' => $ticket
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
    public function viewUser(Request $request, int $id): Response
    {
        $user = $this->em->getRepository(User::class)->find($id);
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
    public function deleteUser(User $user): Response
    {
        $this->em->remove($user);
        $this->em->flush();

        $this->addFlash('success', 'L\'utilisateur <b>' . $user->getName() . '</b> a bien été supprimé !');
        return $this->redirectToRoute('app_dashboard_users');
    }

    /**
     * Gestion des tickets
     * @return Response
     */
    #[Route('/admin/tickets', name: 'app_dashboard_tickets')]
    public function viewTickets(): Response
    {
        $tickets = $this->em->getRepository(Ticket::class)->findAll();

        return $this->render('admin/tickets/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Gestion des départements
     * @return Response
     */
    #[Route('/admin/courses', name: 'app_dashboard_courses')]
    public function viewCourses(): Response
    {
        $courses = $this->em->getRepository(Course::class)->findAll();

        return $this->render('admin/courses/index.html.twig', [
            'courses' => $courses
        ]);
    }

    #[Route('/admin/course/{id}', name: 'app_dashboard_course_form', methods: ['GET', 'POST'])]
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

    /**
     * Gestion des matières
     * @param Request $request
     * @param int $id
     * @return Response
     */
    #[Route('/admin/course/subject/{id}', name: 'app_dashboard_subject_edit', methods: ['GET', 'POST'])]
    public function editSubject(Request $request, int $id): Response
    {
        $subject = $this->em->getRepository(Subject::class)->find($id);
        $form = $this->createForm(SubjectType::class, $subject)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $this->em->flush();
            $this->addFlash('success', 'La matière <b>' . $subject->getName() . '</b> a bien été modifiée !');
            return $this->redirectToRoute('app_dashboard_course_edit', ['id' => $id]);
        }

        return $this->render('admin/courses/subject/edit.html.twig', [
            'subject' => $subject,
            'form' => $form
        ]);
    }
}
