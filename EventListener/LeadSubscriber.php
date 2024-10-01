<?php

namespace MauticPlugin\HostnetNameSanitizerBundle\EventListener;

use Mautic\LeadBundle\Event\LeadEvent;
use Mautic\LeadBundle\LeadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Mautic\LeadBundle\Entity\LeadList;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\HostnetNameSanitizerBundle\Model\HostnetNameSanitizerModel;

class LeadSubscriber implements EventSubscriberInterface
{

    /**
     * @var IntegrationHelper
     */
    private $integrationHelper;

    private $sanitizerModel;

    public function __construct(IntegrationHelper $integrationHelper, HostnetNameSanitizerModel $sanitizerModel)
    {
        $this->integrationHelper = $integrationHelper;
        $this->sanitizerModel = $sanitizerModel;
    }

    public static function getSubscribedEvents()
    {
        return [
            LeadEvents::LEAD_POST_SAVE      => ['onLeadPostSave', 0],
        ];
    }

    public function onLeadPostSave(LeadEvent $event)
    {

        $integration = $this->integrationHelper->getIntegrationObject('HostnetNameSanitizer');
        $featureSettings = $integration->getIntegrationSettings()->getFeatureSettings()['integration'];
        if (false === $integration || !$integration->getIntegrationSettings()->getIsPublished() || $featureSettings['insert_sanitize'] == 'no') {
            return;
        }

        //Pega os dados do lead que está sendo inserido
        $id = $event->getLead()->getId();
        $firstname = $event->getLead()->getFirstname();
        $lastname = $event->getLead()->getLastname();
        $fullName = trim($firstname) . " " . trim($lastname);

        //Faz o tratamento do nome
        $newFullName = $this->sanitizerModel->nameCase($fullName);
        $newFirstname = trim(substr($newFullName, 0, strpos($newFullName, " ")));
        $newLastname = trim(substr($newFullName, strpos($newFullName, " ")));

        //Altera no banco o nome do lead inserido
        if ($newFirstname != $firstname or $newLastname != $lastname) {
            $this->sanitizerModel->updateName($newFirstname, $newLastname, $id);
        }

        return;
    }
}
