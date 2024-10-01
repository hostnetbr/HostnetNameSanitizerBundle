<?php

declare(strict_types=1);

use Mautic\CoreBundle\DependencyInjection\MauticCoreExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $excludes = [];

    $services->load(
        'MauticPlugin\\HostnetNameSanitizerBundle\\',
        '../'
    )
        ->exclude('../{' . implode(',', array_merge(MauticCoreExtension::DEFAULT_EXCLUDES, $excludes)) . '}');

    $services->alias('mautic.hostnetnamesanitizer.model.sanitizer', MauticPlugin\HostnetNameSanitizerBundle\Model\HostnetNameSanitizerModel::class);
};
