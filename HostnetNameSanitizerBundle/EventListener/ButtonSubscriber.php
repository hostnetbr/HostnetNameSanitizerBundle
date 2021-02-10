<?php

/*
 * @author      Pedro de Jesus <pedro.jesus@hostnet.com.br>
 * @link        https://www.hostnet.com.br
 * 
 */

namespace MauticPlugin\HostnetNameSanitizerBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\LeadBundle\Entity\Lead;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\HostnetNameSanitizerBundle\Integration\HostnetNameSanitizerIntegration;
use Symfony\Component\Routing\RouterInterface;

class ButtonSubscriber implements EventSubscriberInterface
{

    /**
     * @var IntegrationHelper
     */
    protected $integrationHelper;

    private $event;

    private $router;

    public function __construct(IntegrationHelper $integrationHelper, RouterInterface $router)
    {
        $this->integrationHelper = $integrationHelper;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0]
        ];
    }

    /**
     * @param CustomButtonEvent $event
     */
    public function injectViewButtons(CustomButtonEvent $event)
    {

        $integration = $this->integrationHelper->getIntegrationObject('HostnetNameSanitizer');
        if (false === $integration || !$integration->getIntegrationSettings()->getIsPublished()) {
            return;
        }

        $event->addButton(
            [
                'attr'      => [
                    'class'       => 'btn btn-default btn-sm btn-nospin',
                    'data-toggle' => '',
                    'data-method' => '',
                    'data-target' => '_blank',
                    'href' => $this->router->generate('hostnet_sanitize_names'),
                    'data-header' => 'Extra Button',
                ],
                'tooltip'   => 'Limpa os nomes dos contatos cadastrados.',
                'btnText' => 'Limpar nomes',
                'iconClass' => 'fa fa-check',
                'primary' => false,
                'priority'  => -1,
            ],
            
            /* ButtonHelper::LOCATION_LIST_ACTIONS,
            'mautic_contact_index' */

            ButtonHelper::LOCATION_TOOLBAR_ACTIONS,
            'mautic_contact_index'

            /* ButtonHelper::LOCATION_PAGE_ACTIONS,
            ['mautic_contact_action', ['objectAction' => 'view']] */
        );
    }

}