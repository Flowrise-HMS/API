<?php

return [
    'type' => 'laravel',
    'routes' => [
        ['prefixes' => ['api/v1/*']],
    ],
    'output_path' => public_path('docs'),
    'theme' => 'default',
    'title' => 'FlowRise HMS API',
    'auth' => [
        'enabled' => true,
        'in' => 'bearer',
        'name' => 'Authorization',
    ],
    'examples' => [
        'fhir_apps' => false,
    ],
];
