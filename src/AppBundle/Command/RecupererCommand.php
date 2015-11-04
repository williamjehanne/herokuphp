<?php
/**
 * Created by PhpStorm.
 * User: williamjehanne
 * Date: 02/11/15
 * Time: 15:15
 */

namespace AppBundle\Command;

use AppBundle\MesClasses\Pizzeria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Predis;

class RecupererCommand extends ContainerAwareCommand
{
    private $pizzeria;
    private $redis;

    protected function configure()
    {
        $this
            ->setName('pizza:recuperer')
            ->setDescription("Recuprer les pizza de l'api")
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->redis = new Predis\Client();

        $output->writeln("Recuperer les pizzas !");
        $this->pizzeria = new Pizzeria($this->getContainer());
        $ensemble_pizzas = $this->pizzeria->recupererPizzas();
        $this->redis->set('ensemble_pizzas',$ensemble_pizzas);
    }
}
