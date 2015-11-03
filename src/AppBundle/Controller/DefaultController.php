<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\MesClasses\Pizzeria;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //$redis = $this->get('snc_redis.default');
        $redis = new \Redis();

        $breakerFactory = new \Ejsmont\CircuitBreaker\Factory();
        //$circuitBreaker = $breakerFactory->getSingleApcInstance(4, 300);
        $circuitBreaker = $breakerFactory->getRedisInstance($redis,4,300);


        $pizzeria = new Pizzeria($this->container);

        $ensemble_pizzas = $pizzeria->recupererPizzasREDIS();
        $json_ensemble_pizzas = json_decode($ensemble_pizzas);

        foreach($json_ensemble_pizzas as $pizza){
            echo "Pizza ".$pizza->name." - ".$pizza->price."<br/> ";
        }

        if($request->isMethod("post")) {
            if( $circuitBreaker->isAvailable("commandePizza") ) {
                try{
                    $pizzeria->commanderPizza();
                    $circuitBreaker->reportSuccess("commandePizza");
                }catch (Exception $e){
                    $circuitBreaker->reportFailure("commandePizza");
                }
            }
        }

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
