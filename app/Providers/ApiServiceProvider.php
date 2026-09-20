<?php

namespace Modules\Api\Providers;

use Modules\Api\Console\Commands\GenerateApiDocs;
use Nwidart\Modules\Support\ModuleServiceProvider;

class ApiServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Api';

    protected string $nameLower = 'api';

    protected array $commands = [
        GenerateApiDocs::class,
    ];

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    public function register(): void
    {
        parent::register();

        // Scribe reads config('scribe') and its own provider has already merged
        // the package defaults; nwidart only exposes the module file as
        // "api.scribe", so overlay it on the key Scribe actually uses.
        $this->app->booting(function (): void {
            $overrides = require module_path($this->name, 'config/scribe.php');

            config()->set('scribe', array_replace_recursive(config('scribe', []), $overrides));
        });
    }
}
