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
            $res = $this->client->request('GET', 'http://pizzapi.herokuapp.com/pizzas',['timeout' => 50]);
            $corpsReponse = $res->getBody();
            return $corpsReponse;

        } catch (\Exception $e) {
            echo "Trop de pizzas à afficher! ";
        }
    }

    public function recupererPizzasREDIS(){
        $redis = $this->container->get('snc_redis.default');
        $ensemble_pizzas = $redis->get('ensemble_pizzas');
    }

    public function commanderPizza(){

        try {
            $res = $this->client->request('POST', 'http://pizzapi.herokuapp.com/orders',
                [
                    'json' => ['id' => 1],
                    'timeout' => 20
                ]
            );

            echo $res->getBody();
        }catch(\Exception $e){
            echo "Beaucoup de commande en ce moment !";
        }
    }

}