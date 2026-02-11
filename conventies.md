# Conventies

Dit document beschrijft de gemaakte afspraken en patronen in deze codebase, gebaseerd op de huidige implementatie.

## Algemeen
- **Framework**: Laravel (Blade + controllers + models).
- **Frontend**: TailwindCSS (utility classes), Alpine.js (kleine UI state), Vite bundling.
- **Taal**: UI-teksten zijn voornamelijk Nederlands.
- **Bestandsstructuur** volgt standaard Laravel-conventies.

## Naamgeving
- **Controllers**: `PascalCase` met suffix `Controller` (bijv. `UserController`).
- **Models**: `PascalCase` enkelvoud (bijv. `ClockEntry`, `Maintenance`).
- **Views**: `kebab-case` of `dot`-notatie in folders (bijv. `resources/views/admin/users/hours.blade.php`).
- **Routes**: `kebab-case` padnamen, route names met `.`-notatie (bijv. `admin.users.hours`).

## Routing
- Routes staan in [routes/web.php](routes/web.php).
- Admin routes zitten in een `role:admin` middleware groep.
- Auth routes zitten binnen `Route::middleware(['auth'])`.
- Route naming gebruikt duidelijke namespaces: `admin.users.*`, `clock.*`.

## Blade & Layouts
- Layouts: gebruik `<x-layouts.app>` voor consistente layout.
- Components en partials worden hergebruikt (bijv. `partials.head`, sidebar/header components).
- UI-teksten zijn doorgaans hardcoded in NL; waar nodig `__()` gebruiken.

## Alpine.js
- Kleine UI-state in Blade via `x-data`.
- Modals gebruiken `x-show` en `x-cloak`.
- Form actions gaan via normale POST (geen JS API-call).

## TailwindCSS
- Styling via utility classes.
- Buttons hebben consistent padding/rounded/hover classes.
- Donkere modus wordt ondersteund met `dark:` varianten.

## Models & Relaties
- `User` heeft `clockEntries()` relatie.
- `ClockEntry` hoort bij `User`.
- Fillable + casts zijn expliciet gedefinieerd.

## Database
- Migrations gebruiken `foreignId()->constrained()->cascadeOnDelete()`.
- Clocking tabel: `clock_entries` met `user_id`, `start_time`, `end_time`, `notes`.

## Clocking flow
- `clock.in` route maakt een entry met `start_time`.
- `clock.out` route vult `end_time` + optionele `notes`.
- UI leest server state met `$isClockedIn`.

## Maintenance mailbox
- IMAP wordt opgehaald via `MaintenanceController::fetchInboxEmails()`.
- Er is een limiet op aantal berichten en fetch van bodies om timeouts te voorkomen.

## Validatie
- Validatie via `$request->validate()` in controllers.
- Notes heeft max lengte (2000) en is nullable.

## Logging
- IMAP fouten en uitzonderingen worden gelogd via `Log::error()` / `Log::debug()`.

## Best practices voor nieuwe code
- Voeg nieuwe routes binnen passende middleware groepen.
- Gebruik `compact()` voor view data.
- Houd UI-strings consistent in NL.
- Voeg relaties en casts toe in models bij nieuwe tabellen.
