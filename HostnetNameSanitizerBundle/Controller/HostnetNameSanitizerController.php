<?php

/*
 * @author      Pedro de Jesus <pedro.jesus@hostnet.com.br>
 * @link        https://www.hostnet.com.br
 * 
 */

namespace MauticPlugin\HostnetNameSanitizerBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class HostnetNameSanitizerController extends FormController
{

    public function sanitizeNamesAction()
    {   

        return $this->processJob();

    }

    private function processJob()
    {

        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
           'command' => 'mautic:sanitize-names'
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);
        $content = $output->fetch();


        $flashes         = [];
        $returnUrl       = $this->generateUrl(
            'mautic_contact_index'
        );
        $flashes[] = [
            'type'    => 'notice',
            'msg'     => nl2br(trim($content))
        ];

        return $this->postActionRedirect(
            [
                'returnURL' => $returnUrl,
                'flashes' => $flashes
            ]
        );
    }
    
}