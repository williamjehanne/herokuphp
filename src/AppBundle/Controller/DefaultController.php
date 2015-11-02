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
        $pizzeria = new Pizzeria();
        $pizzeria->recupererPizzas();

        if($request->isMethod("post")) {
            $pizzeria->commanderPizza();
        }

        // replace this example code with whatever you need

        return $this->render("AppBundle:Default:commande.html.twig");
    }
}
