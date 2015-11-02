<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\MesClasses\Pizzeria;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $redis = $this->get('snc_redis.default');
        $pizzeria = new Pizzeria();
        $ensemble_pizzas = $pizzeria->recupererPizzas();

        //print_r($ensemble_pizzas);

        $redis->set('ensemble_pizzas',$ensemble_pizzas);

        foreach($ensemble_pizzas as $pizza){
            //print_r($pizza);
            //echo "\n Pizza ".$pizza->name;

        }


        //$redis->set('foo','bar');
        //$top20 = $redis->zrevrange('leaderboard', 0, 20,'WITHSCORES');
        //$canSet = $redis->set('exclusive:onehour', 1, 'NX', 'EX', 3600);


        if($request->isMethod("post")) {
            $pizzeria->commanderPizza();
        }

        // replace this example code with whatever you need

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
