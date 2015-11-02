<?php
/**
 * Created by PhpStorm.
 * User: williamjehanne
 * Date: 02/11/15
 * Time: 15:15
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecupererCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('pizza:recuperer')
            ->setDescription("Recuprer les pizza de l'api")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln("Recuperer les pizzas !");
    }
}
