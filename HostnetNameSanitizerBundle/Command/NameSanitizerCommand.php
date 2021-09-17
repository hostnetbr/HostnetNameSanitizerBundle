<?php

/*
 * @author      Pedro de Jesus <pedro.jesus@hostnet.com.br>
 * @link        https://www.hostnet.com.br
 * 
 */

namespace MauticPlugin\HostnetNameSanitizerBundle\Command;

use Mautic\CoreBundle\Command\ModeratedCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Mautic\LeadBundle\Entity\Lead;

class NameSanitizerCommand extends ModeratedCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('mautic:sanitize-names')

        // the short description shown while running "php app/console list"
        ->setDescription('Faz uma validação e correção de todos os nomes na base do Mautic.')

        // the full command description shown when running the command with the "--help" option
        ->setHelp('Este comando vai checar todos os nomes de contatos cadastrados no Mautic e corrigi-los, deixando apenas as primeiras letras em maiúsculo e separando o primeiro nome dos outros.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $model = $this->getContainer()->get('mautic.namesanitizer.model.model'); //Acessa o model
        $names = $model->getNames();

        $altNames = 0;
        $output->writeln("<info>Limpando nomes...</info>");        
        foreach($names as $lead){
            if(strpos(trim($lead['firstname']), trim($lead['lastname'])) !==false){
                $fullName = trim($lead['firstname']);
            }else{
                $fullName = trim($lead['firstname'])." ".trim($lead['lastname']);       
            }
            $newFullName = $model->nameCase($fullName);
            $newFirstname = trim(substr($newFullName, 0, strpos($newFullName, " ")));
            $newLastname = trim(substr($newFullName, strpos($newFullName, " ")));

            if($newFirstname != $lead['firstname'] or $newLastname != $lead['lastname']){
                $model->updateName($newFirstname, $newLastname, $lead['id']);
                $altNames++;
            }

        }
        $output->writeln("<comment>Nomes limpos. $altNames contatos alterados no total.</comment>");

        return;

    }

}
