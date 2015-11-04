<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Predis;

use AppBundle\MesClasses\Pizzeria;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        //$redis = $this->get('snc_redis.default');
        $redis = new Predis\Client(getenv('REDIS_URL'));


        $pizzeria = new Pizzeria($this->container);

        $ensemble_pizzas = $pizzeria->recupererPizzasREDIS();
        $json_ensemble_pizzas = json_decode($ensemble_pizzas);

        foreach($json_ensemble_pizzas as $pizza){
            echo "Pizza ".$pizza->name." - ".$pizza->price."<br/> ";
        }

        if($request->isMethod("post")) {

                    $pizzeria->commanderPizza();


        }

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
