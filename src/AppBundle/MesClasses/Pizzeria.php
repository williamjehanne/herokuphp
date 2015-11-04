<?php

/**
 * Created by PhpStorm.
 * User: jordan
 * Date: 02/11/2015
 * Time: 11:02
 */

namespace AppBundle\MesClasses;

use GuzzleHttp;
use Snc\RedisBundle\Doctrine\Cache\RedisCache;
use Predis\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Exception\MaintenanceException;
use AppBundle\Exception\PizzaApiException;
use Predis;


class Pizzeria
{
    private $client;
    private $container;
    /**
     * Pizzeria constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client       = new GuzzleHttp\Client();
        $this->container    = $container;
    }

    public function recupererPizzas(){

        try{
            $res = $this->client->get('http://pizzapi.herokuapp.com/pizzas',['timeout' => 50]);
            $corpsReponse = $res->getBody()->getContents();
            return $corpsReponse;

        } catch (\Exception $e) {
            echo "Trop de pizzas à afficher! ";
        }
    }

    public function recupererPizzasREDIS(){
        $redis = new Predis\Client(getenv('REDIS_URL'));
        $ensemble_pizzas = $redis->get('ensemble_pizzas');
        return $ensemble_pizzas;
    }

    public function commanderPizza(){

        try {
            $res = $this->client->request('POST', 'http://pizzapi.herokuapp.com/orders',
                [
                    'json' => ['id' => 1],
                    'timeout' => 20
                ]
            );

            if ($res->getStatusCode() === 503) {
                throw new MaintenanceException;
            }
            if ($res->getStatusCode() === 500) {
                throw new PizzaApiException;
            }

            echo $res->getBody();
        }catch(\Exception $e){
            echo "Beaucoup de commande en ce moment !";
        }
    }

}