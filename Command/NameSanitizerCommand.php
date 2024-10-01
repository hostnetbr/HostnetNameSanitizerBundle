<?php

/*
 * @author      Pedro de Jesus <pedro.jesus@hostnet.com.br>
 * @link        https://www.hostnet.com.br
 * 
 */

namespace MauticPlugin\HostnetNameSanitizerBundle\Command;

use Mautic\CoreBundle\Command\ModeratedCommand;
use Mautic\CoreBundle\Helper\CoreParametersHelper;
use Mautic\CoreBundle\Helper\PathsHelper;
use MauticPlugin\HostnetNameSanitizerBundle\Model\HostnetNameSanitizerModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NameSanitizerCommand extends Command
{
    public function __construct(
        private HostnetNameSanitizerModel $sanitizerModel,
    ) {
        parent::__construct();
    }

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
        $names = $this->sanitizerModel->getNames();

        $altNames = 0;
        $output->writeln("<info>Limpando nomes...</info>");
        foreach ($names as $lead) {
            $trimmed_first = trim($lead['firstname']);
            $trimmed_last = trim($lead['lastname']);
            $array_first = explode(" ", $trimmed_first);
            $array_last = explode(" ", $trimmed_last);
            $tamanho_last = sizeof($array_last);
            $tamanho_first = sizeof($array_first);
            for ($ii = $tamanho_last - 1; $ii > -1; $ii--) {
                if ($array_last[$ii] == $array_first[$tamanho_first - 1]) {
                    unset($array_first[$tamanho_first - 1]);
                    $tamanho_first--;
                }
            }
            $lead['firstname'] = implode(" ", $array_first);
            if (strpos(trim($lead['firstname']), trim($lead['lastname'])) !== false) {
                $fullName = trim($lead['firstname']);
            } else {
                $fullName = trim($lead['firstname']) . " " . trim($lead['lastname']);
            }
            $newFullName = $this->sanitizerModel->nameCase($fullName);
            $newFirstname = trim(substr($newFullName, 0, strpos($newFullName, " ")));
            $newLastname = trim(substr($newFullName, strpos($newFullName, " ")));

            if ($newFirstname != $lead['firstname'] or $newLastname != $lead['lastname']) {
                $this->sanitizerModel->updateName($newFirstname, $newLastname, $lead['id']);
                $altNames++;
            }
        }
        $output->writeln("<comment>Nomes limpos. $altNames contatos alterados no total.</comment>");

        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}
