<?php

declare(strict_types=1);

namespace MauticPlugin\HostnetNameSanitizerBundle\Integration\Support;

use Mautic\IntegrationsBundle\Integration\DefaultConfigFormTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormFeatureSettingsInterface;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;
use MauticPlugin\HostnetNameSanitizerBundle\Form\Type\ConfigFeaturesType;
use MauticPlugin\HostnetNameSanitizerBundle\Integration\HostnetNameSanitizerIntegration;

class ConfigSupport extends HostnetNameSanitizerIntegration implements ConfigFormInterface, ConfigFormFeatureSettingsInterface
{
    use DefaultConfigFormTrait;

    public function getFeatureSettingsConfigFormName(): string
    {
        return ConfigFeaturesType::class;
    }
}
