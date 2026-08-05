# Api module

**In one sentence:** Optional REST API scaffolding for mobile and third-party clients — Sanctum token authentication plus Scribe documentation tooling.

## Current status

**In progress.** Token login/logout and Scribe docs generation are implemented. Domain REST resource endpoints (patients, drugs, appointments, etc.) are **not** implemented yet.

See [Module Status](../../docs/shared/module-status.md) for the canonical rollout matrix.

## What is implemented

- `POST /api/v1/auth/login` — email/password → Sanctum personal access token
- `POST /api/v1/auth/logout` — revoke current token (auth:sanctum)
- Scribe documentation tooling (`GenerateApiDocs` command + module Scribe config)
- Feature test: `Modules/Api/tests/Feature/ApiAuthTest.php`

## What is deferred

- Domain REST index/show (or CRUD) endpoints for Patients, Drugs, Dispensing, Services, Appointments, Waitlist, and other operational resources
- Broader Scribe coverage once those endpoints exist

## What happens if this module is disabled

Auth routes registered from `Modules/Api/routes/api.php` are removed. Billing webhooks, Insurance sync, and FHIR endpoints remain available from their own modules regardless of this module's status.

For FHIR R4 clinical exchange, use the **FHIR** module (`/api/v1/fhir/*`), not this module.

## Dependencies

- `Modules\Core` (declared in `module.json`)
- Laravel Sanctum (host app)

## For developers

- **Namespace:** `Modules\Api\...`
- **Service provider:** `Modules\Api\Providers\ApiServiceProvider`
- **Routes:** `Modules/Api/routes/api.php` (auth only today)
- **Docs:** [API Reference](../../docs/developer-guide/api-reference.md)
