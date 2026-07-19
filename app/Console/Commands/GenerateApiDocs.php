<?php

namespace Modules\Api\Console\Commands;

use Illuminate\Console\Command;

class GenerateApiDocs extends Command
{
    protected $signature = 'api:generate-docs';

    protected $description = 'Generate API documentation using Scribe';

    public function handle(): int
    {
        $this->call('scribe:generate', ['--no-interaction' => true, '--force' => true]);

        $this->info('Documentation generated at /docs.');

        return self::SUCCESS;
    }
}
