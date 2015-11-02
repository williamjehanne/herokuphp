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


class Pizzeria
{
    private $client;

    /**
     * Pizzeria constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();
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