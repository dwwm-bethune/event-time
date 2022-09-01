<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'app_event')]
    public function index(EventRepository $repository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $events = $repository->findAll(),
            'incoming' => count(array_filter($events, function ($event) {
                return $event->getStartAt() > new \DateTime();
            })),
        ]);
    }

    #[Route('/evenement/nouveau', name: 'app_event_create')]
    public function create(): Response
    {
        return $this->render('event/create.html.twig');
    }

    #[Route('/evenement/{id}', name: 'app_event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/evenement/{id}/join', name: 'app_event_join')]
    public function join($id): Response
    {
        return new Response('<body>Rejoindre '.$id.'</body>');
    }
}
