<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'app_event')]
    public function index(Request $request, EventRepository $repository): Response
    {
        $events = $repository->search($request->get('q'));

        return $this->render('event/index.html.twig', [
            // 'events' => $events = $repository->findBy([], ['endAt' => 'DESC']),
            'events' => $events,
            'incoming' => count(array_filter($events, function ($event) {
                return $event->getStartAt() > new \DateTime();
            })),
        ]);
    }

    #[Route('/evenement/nouveau', name: 'app_event_create')]
    public function create(
        Request $request,
        EntityManagerInterface $manager,
        EventService $eventService
    ): Response {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $posterFile */
            $posterFile = $form->get('posterFile')->getData();

            if ($posterFile) {
                $filename = $eventService->upload($posterFile);
                // On insère le nom du fichier dans la BDD
                $event->setPoster($filename);
            }

            $manager->persist($event);
            $manager->flush();

            $this->addFlash('success', 'Un événement '.$event->getName().' a été créé.');

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/evenement/{id}', name: 'app_event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/evenement/{id}/join', name: 'app_event_join')]
    public function join(Event $event, MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('noreply@tondomaine.com')
            ->to('admin@tondomaine.com')
            ->subject("Quelqu'un veut rejoindre l'événement")
            ->html('<p>Evénement: '.$event->getName().'</p>');

        $mailer->send($email);

        $this->addFlash('success', 'Vous êtes inscrit à '.$event->getName().'.');

        return $this->redirectToRoute('app_event');
    }
}
