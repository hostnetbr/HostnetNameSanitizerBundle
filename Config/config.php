<?php
return [
    'name'        => 'hostnetnamesanitizer',
    'description' => 'Name sanitizer for Mautic.',
    'version'     => '1.1.0',
    'author'      => 'Pedro de Jesus <pedro.jesus@hostnet.com.br>',
    'routes'      => [
        'main' => [
            'hostnet_sanitize_names' => [
                'path'       => '/name_sanitizer',
                'controller' => 'MauticPlugin\HostnetNameSanitizerBundle\Controller\HostnetNameSanitizerController::sanitizeNamesAction',
            ]
        ]
    ],
    'services' => [
        'events' => [
            'plugin.namesanitizer.button.subscriber' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\EventListener\ButtonSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration',
                    'router',
                ]
            ],
            'plugin.namesanitizer.lead.subscriber' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\EventListener\LeadSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration',
                    'mautic.hostnetnamesanitizer.model.sanitizer'
                ]
            ]
        ],
        'integrations' => [
            'mautic.integration.hostnetnamesanitizer' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\Integration\HostnetNameSanitizerIntegration::class,
                'tags'  => [
                    'mautic.integration',
                    'mautic.basic_integration',
                ],
            ],
            'hostnetnamesanitizer.integration.configuration' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\Integration\Support\ConfigSupport::class,
                'tags'      => [
                    'mautic.config_integration',
                ],
            ],
        ],
    ],
    'menu' => []
];
