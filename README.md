# Symfony Calendar Bundle

A Symfony bundle that provides a full-featured calendar interface and event management system.

---

## ? Installation

1. **Install the bundle via Composer** :

```bash
composer require labrin/calendar-bundle:@dev
```
Register the routes manually in your main Symfony application's **config/routes.yaml**:

```
labrin_calendar:
  resource: '@LabrinCalendarBundle/Resources/config/routes.yaml'
  prefix: /calendar
  ```
Run Doctrine Migrations to create the **Event entity** used by the bundle:

```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
To use the calendar, simply redirect to the **calendar_bundle** route and pass a user parameter.
