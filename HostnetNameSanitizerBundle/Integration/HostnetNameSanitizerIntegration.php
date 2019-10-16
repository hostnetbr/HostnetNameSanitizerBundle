<?php

/*
 * @author      Pedro de Jesus <pedro.jesus@hostnet.com.br>
 * @link        https://www.hostnet.com.br
 * 
 */

namespace MauticPlugin\HostnetNameSanitizerBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use Mautic\PluginBundle\Entity\Integration;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use MauticPlugin\HostnetEmailValidatorBundle\Controller;

class HostnetNameSanitizerIntegration extends AbstractIntegration
{
    public function getName()
    {
        return 'HostnetNameSanitizer';
    }

    public function getDisplayName()
    {
        return 'Name Sanitizer';
    }

    public function getAuthenticationType()
    {
        return 'none';
    }

}