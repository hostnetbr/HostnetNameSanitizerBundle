<?php

declare(strict_types=1);

namespace MauticPlugin\HostnetNameSanitizerBundle\Integration;

use Mautic\IntegrationsBundle\Integration\BasicIntegration;
use Mautic\IntegrationsBundle\Integration\ConfigurationTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\BasicInterface;

class HostnetNameSanitizerIntegration extends BasicIntegration implements BasicInterface
{
    use ConfigurationTrait;

    public const NAME         = 'hostnetnamesanitizer';
    public const DISPLAY_NAME = 'Hostnet Name Sanitizer';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDisplayName(): string
    {
        return self::DISPLAY_NAME;
    }

    public function getIcon(): string
    {
        return 'plugins/HostnetNameSanitizerBundle/Assets/img/hostnetnamesanitizer.png';
    }
}
