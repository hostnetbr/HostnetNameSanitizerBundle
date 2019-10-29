<?php

namespace MauticPlugin\HostnetNameSanitizerBundle\EventListener;

use Mautic\LeadBundle\Event\LeadEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\LeadBundle\Entity\LeadList;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mautic\PluginBundle\Helper\IntegrationHelper;

class LeadSubscriber extends CommonSubscriber
{

    /**
     * @var IntegrationHelper
     */
    protected $integrationHelper;

    public function __construct(IntegrationHelper $integrationHelper)
    {
        $this->integrationHelper = $integrationHelper;
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
        if (false === $integration || !$integration->getIntegrationSettings()->getIsPublished() || !$integration->getInsertSanitize()) {
            return;
        }
        
        //Prepara o Model do plugin
        $pluginModel = $this->factory->getModel('namesanitizer.model');
        
        //Pega os dados do lead que está sendo inserido
        $id = $event->getLead()->getId();
        $firstname = $event->getLead()->getFirstname();
        $lastname = $event->getLead()->getLastname();
        $fullName = trim($firstname)." ".trim($lastname);      
         
        //Faz o tratamento do nome
        $newFullName = $pluginModel->nameCase($fullName);
        $newFirstname = trim(substr($newFullName, 0, strpos($newFullName, " ")));
        $newLastname = trim(substr($newFullName, strpos($newFullName, " ")));

        //Altera no banco o nome do lead inserido
        if($newFirstname != $firstname or $newLastname != $lastname){
            $pluginModel->updateName($newFirstname, $newLastname, $id);
        }      

        return;

    }

}