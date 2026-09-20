# Api module

**In one sentence:** Optional REST API layer for mobile and third-party clients — Sanctum token authentication, Scribe documentation tooling, and the switch that turns on the domain REST endpoints registered by other modules.

## Current status

**In progress.** Token login/logout and Scribe docs generation are implemented. Domain REST endpoints exist for services, patients, staff (+ credentials), drugs, dispenses, appointments and the waitlist; they are registered by `Modules\Core\Services\ApiRouteRegistrar` only while this module is enabled. Broader CRUD coverage (encounters, invoices, ...) is still to come.

See [Module Status](../../docs/shared/module-status.md) for the canonical rollout matrix. Verified against code on 2026-09-20.

## What is implemented

- `POST /api/v1/auth/login` — email/password → Sanctum personal access token (`throttle:5,1`)
- `POST /api/v1/auth/logout` — revoke current token (`auth:sanctum`)
- `GET /api/docs` → redirects to `/docs` (generated Scribe HTML, auth required)
- `php artisan api:generate-docs` — wraps `scribe:generate --force`
- Domain REST routes (Sanctum + `api.branch`) from Core (`services`), Patient (`patients`), Staff (`staff`, `staff/{staff}/credentials`), Pharmacy (`drugs`, `dispenses`), Appointment (`appointments` incl. `check-in`, `cancel`, `bulk-reschedule`; `waitlist`, `waitlist/{id}/offer-slot`) — see [API Reference](../../docs/developer-guide/api-reference.md)
- Feature test: `Modules/Api/tests/Feature/ApiAuthTest.php`

## What is deferred

- REST endpoints for encounters, invoices, inventory and other operational resources
- Scribe coverage of the domain endpoints (the module's `config/scribe.php` is overlaid on `config('scribe')` by `ApiServiceProvider::register()`, so the title, `api/v1/*` route match and auth settings apply; endpoint annotations are still incomplete)

## What happens if this module is disabled

The auth routes and every route registered through `ApiRouteRegistrar` disappear. Billing (`/api/v1/billing/*`), Insurance (`/api/v1/insurance/*`) and FHIR (`/api/v1/fhir/*`) endpoints remain available from their own modules regardless of this module's status.

For FHIR R4 clinical exchange, use the **FHIR** module, not this module.

## Dependencies

- `Modules\Core` (declared in `module.json`)
- Laravel Sanctum (host app; `SANCTUM_STATEFUL_DOMAINS`, `SANCTUM_TOKEN_PREFIX`)

## For developers

- **Namespace:** `Modules\Api\...`
- **Service provider:** `Modules\Api\Providers\ApiServiceProvider`
- **Routes:** `Modules/Api/routes/api.php` (auth), `routes/web.php` (`/api/docs` redirect)
- **Branch scoping:** `api.branch` = `Modules\Core\Http\Middleware\SetCurrentApiBranch` (403 when the token owner has no branch)
- **Docs:** [API Reference](../../docs/developer-guide/api-reference.md)
