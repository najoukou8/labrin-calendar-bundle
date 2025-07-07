# Symfony Calendar Bundle

A Symfony bundle that provides a full-featured calendar interface and event management system.

---

## Installation

1. **Install the bundle via Composer** :

```bash
composer require labrin/calendar-bundle:dev-main
```
2. **Register the routes** 
 
Add the following to your main Symfony application's config/routes.yaml to load the bundle routes under /calendar
```
calendar:
  resource: '@LabrinCalendarBundle/Resources/config/routes.yaml'
  prefix: /calendar
  ```
3. **Run Doctrine Migrations**

Create and apply migrations for the Event entity used by the bundle:

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Usage
1. **Inject and call the CalendarService in your controller**

Use the bundle?s calendar service to fetch event data for a specific user:

```
// In your controller
$data = $this->calendarService->getCalendarDataForUser($user);

return $this->render('test/index.html.twig', [
'events' => $data['events'],
'draggableEvents' => $data['draggableEvents'],
'user' => $user,
]);
```
2. **Include the calendar Twig template in your view**

Embed the calendar UI by including the bundle's Twig template:

```
{# test/index.html.twig #}
{% include '@LabrinCalendar/calendar/index.html.twig' %}
```
## Note
- make sure to provide a user when fetching calendar data.
- You can render the calendar anywhere in your application by calling the service and including the Twig template.
