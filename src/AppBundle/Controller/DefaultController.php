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
        $pizzeria = new Pizzeria($this->container);

        $ensemble_pizzas = $pizzeria->recupererPizzasREDIS();
        $json_ensemble_pizzas = json_decode($ensemble_pizzas);
        //echo $json_ensemble_pizzas;
        //$redis->get('ensemble_pizzas');

        foreach($json_ensemble_pizzas as $pizza){

            echo "Pizza ".$pizza->name." - ".$pizza->price."<br/> ";
        }

        if($request->isMethod("post")) {
            $pizzeria->commanderPizza();
        }

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
