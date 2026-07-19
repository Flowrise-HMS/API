# Api module

**In one sentence:** Optional REST API scaffolding for mobile and third-party clients — Sanctum token authentication plus Scribe documentation tooling.

## Current status

**In progress.** Token login/logout and Scribe docs generation are built. Domain REST resource endpoints (patients, encounters, billing, etc.) are not yet implemented.

See [Module Status](../../docs/shared/module-status.md) for the canonical matrix.

## What is implemented

- `POST /api/v1/auth/login` — email/password → Sanctum personal access token
- `POST /api/v1/auth/logout` — revoke current token (auth:sanctum)
- Scribe configuration (`Modules/Api/config/scribe.php`) and `GenerateApiDocs` Artisan command
- Feature test: `Modules/Api/tests/Feature/ApiAuthTest.php`

## What is deferred

- Domain REST CRUD resources beyond auth
- Broader OpenAPI/Scribe endpoint coverage as those resources land

For FHIR R4 clinical exchange, use the **FHIR** module (`/api/v1/fhir/*`), not this module.

## Dependencies

- `Modules\Core` (declared in `module.json`)
- Laravel Sanctum (host app)

## For developers

- **Namespace:** `Modules\Api\...`
- **Service provider:** `Modules\Api\Providers\ApiServiceProvider`
- **Routes:** `Modules/Api/routes/api.php`
- **Docs:** [API Reference](../../docs/developer-guide/api-reference.md)
