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
}
