<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Homework;
use App\Entity\Ticket;
use App\Form\TicketHomeworkType;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class TicketController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/ticket/create/{homeworkId}', name: 'app_ticket_create', methods: ['GET', 'POST'])]
    public function createTicket(Request $request, int $homeworkId): Response
    {
        $homework = $this->em->getRepository(Homework::class)->find($homeworkId);
        if ($homework) {
            $ticket = new Ticket();
            $form = $this->createForm(TicketType::class, $ticket, [
                'action' => $this->generateUrl('app_ticket_create', ['homeworkId' => $homeworkId]),
                'method' => 'POST',
            ])->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $ticket->setHomework($homework);
                $ticket->setAuthor($this->getUser());
                $ticket->setStatus(0);
                $this->em->persist($ticket);
                $this->em->flush();
                $this->addFlash('success', 'Le signalement a bien été créé !');
            } elseif(!$form->isSubmitted()) {
                return $this->render('ticket/create.html.twig', [
                    'form' => $form->createView(),
                    'homework' => $homework
                ]);
            }
        } else {
            $this->addFlash('danger', 'Le devoir n\'existe pas !');
        }
        return $this->redirectToRoute('app_index');
    }

    /**
     * Gestion des tickets
     * @param AuthorizationCheckerInterface $checker
     * @return Response
     */
    #[Route('/admin/tickets', name: 'app_dashboard_tickets')]
    public function viewTickets(AuthorizationCheckerInterface $checker): Response
    {
        $currentUser = $this->getUser();

        if ($checker->isGranted('ROLE_MOD') && !$checker->isGranted('ROLE_ADMIN') && !$checker->isGranted('ROLE_SUPER_ADMIN')) {
            $group = $currentUser->getGroup();
            $ticketRepo = $this->em->getRepository(Ticket::class);
            $tickets = $ticketRepo->createQueryBuilder('t')
                ->leftJoin('t.homework', 'h')
                ->andWhere('h.group = :group')
                ->setParameter('group', $group)
                ->getQuery()
                ->getResult();
        } else {
            $tickets = $this->em->getRepository(Ticket::class)->findBy([], ['status' => 'ASC', 'id' => 'DESC']);
        }

        return $this->render('admin/tickets/index.html.twig', [
            'tickets' => $tickets
        ]);
    }

    #[Route('/admin/ticket/{id}', name: 'app_dashboard_ticket_view', methods: ['GET', 'POST'])]
    public function viewTicket(Request $request, int $id): Response
    {
        $ticket = $this->em->getRepository(Ticket::class)->find($id);

        if (!$ticket) {
            $this->addFlash('danger', 'Le ticket n\'existe pas !');
            return $this->redirectToRoute('app_dashboard_tickets');
        } else {
            $homework = $ticket->getHomework();
            $form = $this->createForm(TicketHomeworkType::class, $homework)->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $form->getData();
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard_ticket_view', ['id' => $id]);
            }

        }

        return $this->render('admin/tickets/view.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/ticket/resolved/{id}', name: 'app_dashboard_ticket_resolved', methods: ['GET'])]
    public function markResolved(int $id): Response
    {
        $ticket = $this->em->getRepository(Ticket::class)->find($id);
        if ($ticket) {
            $ticket->setResolved();
            $this->em->flush();
            $this->addFlash('success', 'Le ticket #' . $ticket->getId() . ' a bien été marqué comme résolu !');
        } else {
            $this->addFlash('danger', 'Le ticket n\'existe pas !');
        }
        return $this->redirectToRoute('app_dashboard_tickets');
    }

    #[Route('/admin/comment/delete/{id}', name: 'app_dashboard_comment_delete', methods: ['GET'])]
    public function deleteComment(int $id, RequestStack $requestStack): Response
    {
        $referer = $requestStack->getMainRequest()->headers->get('referer');
        $comment = $this->em->getRepository(Comment::class)->find($id);
        if ($comment) {
            $this->em->remove($comment);
            $this->em->flush();
            $this->addFlash('success', 'Le commentaire a bien été supprimé !');
        } else {
            $this->addFlash('danger', 'Le commentaire n\'existe pas !');
        }
        return $this->redirect($referer);
    }
}
