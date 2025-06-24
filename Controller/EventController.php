<?php

namespace Labrin\CalendarBundle\Controller;


use App\CalendarBundle\Entity\Events;
use App\CalendarBundle\Repository\EventsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class EventController extends AbstractController
{


    /**
     * @Route("/addEvent", name="app_add_event", methods={"POST"})
     */
    public function addEvent(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['success' => false, 'error' => 'Invalid input.'], 400);
        }
        try {
            $event = new Events();
            $event->setTitre($data['title']);
            $event->setStart(isset($data['startDateTime']) ? (string)$data['startDateTime'] : "");
            $event->setEnd(isset($data['endDateTime']) ? (string)$data['endDateTime'] : "");
            $event->setDescription(isset($data['description']) ? $data['description'] : "");
            $event->setLocation(isset($data['location']) ? $data['location'] : "");
            $event->setTask(isset($data['isTask']) ? $data['isTask'] : "0");
            $event->setUser($data['user']);
            $event->setColor(isset($data['color']) ? $data['color'] : null);
            $entityManager->persist($event);
            $entityManager->flush();

        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }

        return new JsonResponse(['success' => true]);
    }
    /**
     * @Route("/DeleteEvent", name="app_events_delete", methods={"POST"})
     */
    public function deleteEvent(Request $request, EntityManagerInterface $entityManager, EventsRepository $eventsRepository): Response
    {
        $data= json_decode( $request->getContent(), true);

        if (!isset($data['eventId'])) {
            return new JsonResponse(['success' => false, 'error' => 'Event ID is required.'], 400);
        }
        try {
            $eventId= $data['eventId'];
            $event = $eventsRepository->find($eventId);
            $entityManager->remove($event);
            $entityManager->flush();
            return new JsonResponse(['success' => true]);
        }
        catch (\Exception $e) {
            return new JsonResponse(['success' => false, 'error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * @Route("/UpdateEvent", name="app_events_update", methods={"POST"})
     */
    public function UpdateEvent(Request $request, EntityManagerInterface $entityManager, EventsRepository $eventsRepository): Response
    {
        $data= json_decode( $request->getContent(), true);

        $event = $eventsRepository->find($data['id']);
        if (!$event) {
            return new JsonResponse(['success' => false, 'error' => 'Event not found.'], 404);
        }
        try {
            if (isset($data['title'])) {
                $event->setTitre($data['title']);
            }
            if (isset($data['start'])) {
                $event->setStart($data['start']);
            }
            if (isset($data['end'])) {
                $event->setEnd($data['end']);
            }
            if (isset($data['description'])) {
                $event->setDescription($data['description']);
            }
            if (isset($data['location'])) {
                $event->setLocation($data['location']);
            }
            if (isset($data['isTask'])) {
                $event->setTask($data['isTask']);
            }
            if(isset($data['color'])) {
                $event->setColor($data['color']);
            }

            $entityManager->flush();
            return new JsonResponse(['success' => true]);
        }
        catch (\Exception $e) {
          return new JsonResponse(['success' => false, 'error' => 'An unexpected error occurred.'], 500);
        }
    }
}

