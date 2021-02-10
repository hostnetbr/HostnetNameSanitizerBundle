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
use Mautic\CoreBundle\Form\Type\YesNoButtonGroupType;

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

    public function appendToForm(&$builder, $data, $formArea)
    {
        if ($formArea === 'features') {
            $builder->add(
                'insert_sanitize',
                YesNoButtonGroupType::class,
                [
                    'label' => 'Limpar nome na inserção do contato?',
                    'data' => (isset($data['insert_validation']) ? $data['insert_validation'] : false),
                    'attr'  => [
                        'tooltip' => 'Se marcado como sim, o plugin irá limpar o nome do contato no momento que ele for cadastrado (via formulário, importação ou manualmente).',
                    ],
                ]
            );
        }
    }

    public function getInsertSanitize()
    {
        $featureSettings = $this->getKeys();

        return isset($featureSettings['insert_sanitize'])
            ? $featureSettings['insert_sanitize']
            : false;
    }

}