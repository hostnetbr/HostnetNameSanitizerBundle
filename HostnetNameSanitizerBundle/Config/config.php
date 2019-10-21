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
                    'mautic.helper.integration'
                ]
            ],
        ],
        'integrations' => [
            'mautic.integration.HostnetNameSanitizer' => [
                'class'     => \MauticPlugin\HostnetNameSanitizerBundle\Integration\HostnetNameSanitizerIntegration::class,
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