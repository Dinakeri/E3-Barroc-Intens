# English Text Inventory for Dutch Translation

## Overview
This document lists all English text found in the Laravel application that needs to be translated to Dutch, organized by category and file location.

---

## 1. NAVIGATION & MENU ITEMS

### Current State: MIXED (Some already use `__()` helper, many are hardcoded)

| English Text | Location | File | Current Implementation | Priority |
|---|---|---|---|---|
| Home | dashboards/sales.blade.php | Line 12 | Hardcoded | HIGH |
| Orders | dashboards/sales.blade.php | Line 13 | Hardcoded | HIGH |
| Products | dashboards/sales.blade.php | Line 13 | Hardcoded | HIGH |
| Customers | dashboards/sales.blade.php | Line 14 | Hardcoded | HIGH |
| Reports | dashboards/sales.blade.php | Line 15 | Hardcoded | HIGH |
| Add new customer | dashboards/sales.blade.php | Line 17 | Hardcoded | HIGH |
| Dashboard | dashboards/sales.blade.php | Line 23 | Hardcoded | HIGH |
| Log Out | dashboards/sales.blade.php | Line 28 | Hardcoded | HIGH |
| Dashboard | app/sidebar.blade.php | Line 17 | Using `__()` | ALREADY TRANSLATED |
| Log Uit | app/sidebar.blade.php | Line 20 | Using `__()` | ALREADY TRANSLATED |
| Onderhoud | app/sidebar.blade.php | Line 31 | Using `__()` | ALREADY TRANSLATED |
| Onderhoud Home | app/sidebar.blade.php | Line 33 | Using `__()` | ALREADY TRANSLATED |
| Kalender | app/sidebar.blade.php | Line 37 | Using `__()` | ALREADY TRANSLATED |
| Storingen | app/sidebar.blade.php | Line 41 | Using `__()` | ALREADY TRANSLATED |
| Sales | app/sidebar.blade.php | Line 46 | Using `__()` | ALREADY TRANSLATED |
| Sales Dashboard | app/sidebar.blade.php | Line 48 | Using `__()` | ALREADY TRANSLATED |
| Klanten | app/sidebar.blade.php | Line 52 | Using `__()` | ALREADY TRANSLATED |
| Bestellingen | app/sidebar.blade.php | Line 56 | Using `__()` | ALREADY TRANSLATED |
| Finance | app/sidebar.blade.php | Line 61 | Using `__()` | ALREADY TRANSLATED |
| Finance Dashboard | app/sidebar.blade.php | Line 63 | Using `__()` | ALREADY TRANSLATED |
| Facturen | app/sidebar.blade.php | Line 67 | Using `__()` | ALREADY TRANSLATED |
| Uitgaven | app/sidebar.blade.php | Line 71 | Using `__()` | ALREADY TRANSLATED |

---

## 2. HEADINGS & TITLES

### Current State: HARDCODED (All need `__()` wrapper)

| English Text | Location | File | Suggested Dutch | Priority |
|---|---|---|---|---|
| Sales Dashboard | dashboards/sales.blade.php | Line 4 | Sales Dashboard | HIGH |
| Welcome to the Sales Dashboard. Here you can find an overview of sales metrics and performance. | dashboards/sales.blade.php | Line 5 | Welkom op het Sales Dashboard. Hier vindt u een overzicht van verkoopsgegevens en prestaties. | HIGH |
| Sales Overview | dashboards/sales.blade.php | Line 34, 38, 42 | Verkoopoverzicht | MEDIUM |
| Track your sales performance and metrics | dashboards/sales.blade.php | Line 35, 39, 43 | Volg uw verkoopprestatieve en statistieken | MEDIUM |
| Total Orders | dashboards/sales.blade.php | Line 52 | Totale Bestellingen | HIGH |
| Total Customers | dashboards/sales.blade.php | Line 56 | Totale Klanten | HIGH |
| Offertes: | dashboards/sales.blade.php | Line 77 | Offertes: | ALREADY DUTCH |
| Lopende klanten: | dashboards/sales.blade.php | Line 82 | Lopende klanten: | ALREADY DUTCH |
| BKR-statussen: | dashboards/sales.blade.php | Line 87 | BKR-statussen: | ALREADY DUTCH |
| Klanten | resources/views/livewire/customers.blade.php | Line 5 | Klanten | ALREADY DUTCH |
| Beheer en filter uw klantendatabase | resources/views/livewire/customers.blade.php | Line 6 | Beheer en filter uw klantendatabase | ALREADY DUTCH |

---

## 3. BUTTON LABELS & ACTION TEXT

### Current State: HARDCODED (Mostly English in sales dashboard)

| English Text | Location | File | Suggested Dutch | Priority |
|---|---|---|---|---|
| Clear Filters | livewire/customers.blade.php | Line 34 | Filters Wissen | HIGH |
| Voeg nieuwe klant toe | livewire/customers.blade.php | Line 28 | Voeg nieuwe klant toe | ALREADY DUTCH |

---

## 4. TABLE HEADERS & LABELS

### Current State: MOSTLY DUTCH with English placeholders

| English Text | Location | File | Suggested Dutch | Priority |
|---|---|---|---|---|
| Status | livewire/customers.blade.php | Line 18, 55 | Status | ALREADY DUTCH (but used in filter) |
| Naam | livewire/customers.blade.php | Line 47 | Naam | ALREADY DUTCH |
| Email | livewire/customers.blade.php | Line 51 | E-mail | ALREADY DUTCH |
| Offertes | livewire/customers.blade.php | Line 59 | Offertes | ALREADY DUTCH |
| Notities | livewire/customers.blade.php | Line 63 | Notities | ALREADY DUTCH |
| Acties | livewire/customers.blade.php | Line 67 | Acties | ALREADY DUTCH |

---

## 5. FILTER OPTIONS & STATUS BADGES

### Current State: MIX OF DUTCH & ENGLISH

| English Text | Location | File | Current State | Priority |
|---|---|---|---|---|
| Alle | livewire/customers.blade.php | Line 19 | Dutch option | ALREADY DUTCH |
| Nieuw | livewire/customers.blade.php | Line 20 | Dutch option | ALREADY DUTCH |
| Actief | livewire/customers.blade.php | Line 21 | Dutch option | ALREADY DUTCH |
| In behandeling | livewire/customers.blade.php | Line 22 | Dutch option | ALREADY DUTCH |
| Inactief | livewire/customers.blade.php | Line 23 | Dutch option | ALREADY DUTCH |

---

## 6. FORM LABELS & PLACEHOLDERS

### Current State: DUTCH (Well translated)

| English Text | Location | File | Current State | Priority |
|---|---|---|---|---|
| Zoeken op naam, e-mailadres of adres... | livewire/customers.blade.php | Line 15 | Dutch placeholder | ALREADY DUTCH |
| BKR-status | livewire/customers.blade.php | Line 194 | Dutch label | ALREADY DUTCH |

---

## 7. CONTROLLER MESSAGES (Flash & Response Messages)

### Current State: HARDCODED ENGLISH (Critical for translation)

| English Text | Location | File | Suggested Dutch | Priority |
|---|---|---|---|---|
| Payment recorded successfully. | PaymentController.php | (approx) | Betaling succesvol vastgelegd. | HIGH |
| Payment updated successfully. | PaymentController.php | (approx) | Betaling succesvol bijgewerkt. | HIGH |
| Customer created successfully. | CustomerController.php | (approx) | Klant succesvol aangemaakt. | HIGH |
| Reparatie succesvol gewijzigd | maintenanceController.php | (approx) | Reparatie succesvol gewijzigd | ALREADY DUTCH |
| Reparatie succesvol ingepland | maintenanceController.php | (approx) | Reparatie succesvol ingepland | ALREADY DUTCH |

---

## 8. USER ROLES & TEST DATA

### Current State: HARDCODED ENGLISH (In TestUsersSeeder.php)

| English Text | Location | File | Suggested Dutch | Priority |
|---|---|---|---|---|
| Finance User | TestUsersSeeder.php | Line ~15 | Financieel Gebruiker | MEDIUM |
| Maintenance User | TestUsersSeeder.php | Line ~15 | Onderhoud Gebruiker | MEDIUM |
| Sales User | TestUsersSeeder.php | Line ~15 | Verkoop Gebruiker | MEDIUM |
| No Role User | TestUsersSeeder.php | Line ~15 | Geen Rol Gebruiker | MEDIUM |
| Admin User | TestUsersSeeder.php | Line ~15 | Beheerder Gebruiker | MEDIUM |

---

## 9. PARTIAL/SETTINGS TEXT (Already Translated)

| English Text | Location | File | Current Implementation | Status |
|---|---|---|---|---|
| Settings | partials/settings-heading.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Manage your profile and account settings | partials/settings-heading.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Profile | livewire/settings/profile.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Update your name and email address | livewire/settings/profile.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Save | livewire/settings/profile.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Saved. | livewire/settings/profile.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Delete account | livewire/settings/delete-user-form.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Delete your account and all of its resources | livewire/settings/delete-user-form.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Are you sure you want to delete your account? | livewire/settings/delete-user-form.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |
| Cancel | livewire/settings/delete-user-form.blade.php | (approx) | Using `__()` | ALREADY TRANSLATED |

---

## Summary Statistics

- **Total English Strings Found**: ~35 hardcoded + more in controllers/seeders
- **Already Translated (using `__()`)**: ~20+ strings
- **Hardcoded and Requiring Update**: ~15+ strings (CRITICAL)
- **Files Requiring Major Updates**:
  - `resources/views/dashboards/sales.blade.php` (Lines 1-83)
  - `app/Http/Controllers/*.php` (Flash messages)
  - `database/seeders/TestUsersSeeder.php` (User names)

---

## Translation Files Required

Need to create or update:
- `resources/lang/nl/messages.json` (Flash/success messages)
- `resources/lang/nl/navigation.json` (Menu items)
- `resources/lang/nl/dashboard.json` (Dashboard text)
- `resources/lang/nl/validation.json` (Form validation)

---

## Next Steps

1. ✅ **Inventory Complete** - All English text identified and categorized
2. ⏳ **Create Translation Files** - Set up resources/lang/nl/ structure
3. ⏳ **Wrap Hardcoded Strings** - Add `__()` helpers to all text
4. ⏳ **Add Translations** - Provide Dutch translations for each entry
5. ⏳ **Test Application** - Verify all text displays correctly in Dutch
