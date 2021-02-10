<?php
return [
    'name'        => 'Name Sanitizer',
    'description' => 'Name sanitizer for Mautic.',
    'version'     => '1.1.0',
    'author'      => 'Pedro de Jesus <pedro.jesus@hostnet.com.br>',
    'routes'      => [
        'main' => [
            'hostnet_sanitize_names' => [
                'path'       => '/name_sanitizer',
                'controller' => 'HostnetNameSanitizerBundle:HostnetNameSanitizer:sanitizeNames',
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
                    'mautic.namesanitizer.model.model'
                ]
            ]
        ],
        'integrations' => [
            'mautic.integration.HostnetNameSanitizer' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\Integration\HostnetNameSanitizerIntegration::class,
                'arguments' => [
                    'event_dispatcher',
                    'mautic.helper.cache_storage',
                    'doctrine.orm.entity_manager',
                    'session',
                    'request_stack',
                    'router',
                    'translator',
                    'logger',
                    'mautic.helper.encryption',
                    'mautic.lead.model.lead',
                    'mautic.lead.model.company',
                    'mautic.helper.paths',
                    'mautic.core.model.notification',
                    'mautic.lead.model.field',
                    'mautic.plugin.model.integration_entity',
                    'mautic.lead.model.dnc',
                ],
            ]
        ],
        'models' => [
            'mautic.namesanitizer.model.model' => [
                'class' => \MauticPlugin\HostnetNameSanitizerBundle\Model\HostnetNameSanitizerModel::class,
                'alias' => 'namesanitizer.model'
            ]
        ],
        'other' =>[
            
        ]
    ],
    'menu' => [

    ]
];