<?php

namespace Modules\Api\Tests\Feature;

use Tests\TestCase;

class ScribeConfigTest extends TestCase
{
    public function test_module_scribe_config_overlays_the_package_defaults(): void
    {
        $this->assertSame('FlowRise HMS API', config('scribe.title'));
        $this->assertContains('api/v1/*', config('scribe.routes.0.prefixes', config('scribe.routes.0.match.prefixes', [])));
    }
}
