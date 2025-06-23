<?php

namespace App\CalendarBundle\Controller;


use App\CalendarBundle\Repository\EventsRepository;

use iio\libmergepdf\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="app_calendar")
     */
    public function index(Request $request,EventsRepository $eventsRepository): Response
    {

        $eventsArray=[];
        $user=$request->attributes->get('user');
        if (empty($user)) {
            return new JsonResponse(['success' => false, 'error' => 'User not found'], 400);
        }
        $session = $request->getSession();
        $session->set('user', $user);
        //$user="labrin";

        $eventsWithoutDates = $eventsRepository->findBy(["user"=>$user, "isTask"=>1]);

        $draggableEventsArray = [];
        foreach ($eventsWithoutDates as $event) {
            $draggableEventsArray[] = [
                'id' => $event->getId(),
                'title' => $event->getTitre(),
            ];
        }
        $events= $eventsRepository->findBy(["user"=>$user]);
        foreach ($events as $event) {
            $isAllday= false;
            $startDay = new \DateTime($event->getStart());
            $endDay = new \DateTime($event->getEnd());

            $startFormatted = $startDay->format("Y-m-d");
            $endFormatted = $endDay->format("Y-m-d");
            if ($startFormatted !== $endFormatted){
                $isAllday=true;
            }


            $eventsArray[] = [
                'id' => $event->getId(),
                'title' => $event->getTitre(),
                'uid' => $event->getUid(),
                'start' => $event->getStart(),
                'end' => $event->getEnd(),
                'location' => $event->getLocation(),
                'categorie' => $event->getCategorie(),
                'description' => $event->getDescription(),
                'allDay'=> $isAllday,
                'color'=>$event->getColor(),
                'user'=>$event->getUser(),
            ];
        }
        return $this->render('@Calendar/calendar/index.html.twig',[
            'events' => json_encode($eventsArray),
            'draggableEvents' => $draggableEventsArray,
            'user' => $user,
        ]);
    }

}
