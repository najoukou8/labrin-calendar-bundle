<?php

namespace Labrin\CalendarBundle\Controller;


use iio\libmergepdf\Exception;
use Labrin\CalendarBundle\Repository\EventsRepository;
use Labrin\CalendarBundle\Service\CalendarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends AbstractController
{
    private  $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * @Route("/", name="app_calendar")
     */
    public function index(Request $request): Response
    {
        $user = $request->query->get('user');
        if (empty($user)) {
            return new JsonResponse(['success' => false, 'error' => 'User not found'], 400);
        }
        $session = $request->getSession();
        $session->set('user', $user);

        $data = $this->calendarService->getCalendarDataForUser($user);

        return $this->render('@LabrinCalendar/calendar/index.html.twig', [
            'events' => $data['events'],
            'draggableEvents' => $data['draggableEvents'],
            'user' => $user,
        ]);
    }
}
