# Api module

**In one sentence:** Optional REST API scaffolding for mobile and third-party clients — Sanctum token authentication plus Scribe documentation tooling.

## Current status

**Production-ready.** Token login/logout, Scribe docs generation, and domain REST resource endpoints are all implemented and gated behind this module. Disabling the Api module removes all resource endpoints.

## What is implemented

- `POST /api/v1/auth/login` — email/password → Sanctum personal access token
- `POST /api/v1/auth/logout` — revoke current token (auth:sanctum)
- Scribe v5 auto-generated API documentation at `/docs`
- Read-only resource index/show endpoints for: Patients, Drugs, Dispensing, Services, Appointments, Waitlist
- Feature test: `Modules/Api/tests/Feature/ApiAuthTest.php`

## What happens if this module is disabled

All routes registered through `ApiRouteRegistrar` (all domain REST resources) are removed. Billing webhooks, Insurance sync, and FHIR endpoints are always available regardless of this module's status.

For FHIR R4 clinical exchange, use the **FHIR** module (`/api/v1/fhir/*`), not this module.

## Dependencies

- `Modules\Core` (declared in `module.json`)
- Laravel Sanctum (host app)

## For developers

- **Namespace:** `Modules\Api\...`
- **Service provider:** `Modules\Api\Providers\ApiServiceProvider`
- **Routes:** `Modules/Api/routes/api.php`
- **Docs:** [API Reference](../../docs/developer-guide/api-reference.md)
