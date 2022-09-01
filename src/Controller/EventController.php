<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    protected $events = [
        ['id' => 1, 'name' => 'Concert 1', 'description' => 'Lorem', 'price' => 10, 'createdAt' => '2022-08-28 11:38:45', 'startAt' => '2022-08-28 11:38:45', 'endAt' => '2022-08-29 11:38:45'],
        ['id' => 2, 'name' => 'Concert 2', 'description' => 'Lorem', 'price' => 20, 'createdAt' => '2022-08-30 11:38:45', 'startAt' => '2022-08-30 11:38:45', 'endAt' => '2022-09-02 11:38:45'],
        ['id' => 3, 'name' => 'Concert 3', 'description' => 'Lorem', 'price' => 30, 'createdAt' => '2022-09-02 11:38:45', 'startAt' => '2022-09-02 11:38:45', 'endAt' => '2022-09-03 11:38:45'],
    ];

    #[Route('/evenements', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $this->events,
            'incoming' => count(array_filter($this->events, function ($event) {
                return new \DateTime($event['startAt']) > new \DateTime();
            })),
        ]);
    }

    #[Route('/evenement/nouveau', name: 'app_event_create')]
    public function create(): Response
    {
        return $this->render('event/create.html.twig');
    }

    #[Route('/evenement/{id}', name: 'app_event_show')]
    public function show($id): Response
    {
        if (! in_array($id, array_column($this->events, 'id'))) {
            throw $this->createNotFoundException();
        }

        return $this->render('event/show.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/evenement/{id}/join', name: 'app_event_join')]
    public function join($id): Response
    {
        return new Response('<body>Rejoindre '.$id.'</body>');
    }
}
