 <?php
return [
    'name'        => 'Name Sanitizer',
    'description' => 'Name sanitizer for Mautic.',
    'version'     => '1.0.0',
    'author'      => 'Pedro de Jesus <pedro.jesus@hostnet.com.br>',
    'routes'      => [
        'main' => [
        ]
    ],
    'services' => [
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