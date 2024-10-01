<?php

declare(strict_types=1);

namespace MauticPlugin\HostnetNameSanitizerBundle\Form\Type;

use Mautic\CoreBundle\Form\Type\YesNoButtonGroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigFeaturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('insert_sanitize', YesNoButtonGroupType::class, [
            'no_value'  => 'no',
            'yes_value' => 'yes',
            'label'     => 'Limpar nome na inserção do contato?',
            'attr'  => [
                'tooltip' => 'Se marcado como sim, o plugin irá limpar o nome do contato no momento que ele for cadastrado (via formulário, importação ou manualmente).',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'integration' => true,
        ]);

        $resolver->setAllowedTypes('integration', 'bool');
    }
}
