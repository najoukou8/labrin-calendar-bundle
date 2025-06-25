<?php

namespace Labrin\CalendarBundle\Service;

use Labrin\CalendarBundle\Repository\EventsRepository;

class CalendarService
{
    private  $eventsRepository;

    public function __construct(EventsRepository $eventsRepository)
    {
        $this->eventsRepository = $eventsRepository;
    }

    /**
     * Returns an array with keys 'events' (json string) and 'draggableEvents' (array) for a user.
     */
    public function getCalendarDataForUser(string $user): array
    {
        $eventsArray = [];

        $eventsWithoutDates = $this->eventsRepository->findBy(["user" => $user, "isTask" => 1]);

        $draggableEventsArray = [];
        foreach ($eventsWithoutDates as $event) {
            $draggableEventsArray[] = [
                'id' => $event->getId(),
                'title' => $event->getTitre(),
            ];
        }

        $events = $this->eventsRepository->findBy(["user" => $user]);

        foreach ($events as $event) {
            $isAllday = false;
            $startDay = new \DateTime($event->getStart());
            $endDay = new \DateTime($event->getEnd());

            $startFormatted = $startDay->format("Y-m-d");
            $endFormatted = $endDay->format("Y-m-d");
            if ($startFormatted !== $endFormatted) {
                $isAllday = true;
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
                'allDay' => $isAllday,
                'color' => $event->getColor(),
                'user' => $event->getUser(),
            ];
        }

        return [
            'events' => json_encode($eventsArray),
            'draggableEvents' => $draggableEventsArray,
        ];
    }
}