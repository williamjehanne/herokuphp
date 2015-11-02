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
        $ensemble_pizzas = $pizzeria->recupererPizzasREDIS();

        //print_r($ensemble_pizzas);

        $redis->get('ensemble_pizzas');

        foreach($ensemble_pizzas as $pizza){
            //print_r($pizza);
            //echo "\n Pizza ".$pizza->name;
        }

        if($request->isMethod("post")) {
            $pizzeria->commanderPizza();
        }

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
