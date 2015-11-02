<?php

/**
 * Created by PhpStorm.
 * User: jordan
 * Date: 02/11/2015
 * Time: 11:02
 */

namespace AppBundle\MesClasses;

use GuzzleHttp;

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
        /*$request = new \GuzzleHttp\Psr7\Request('GET', 'http://pizzapi.herokuapp.com/pizzas');
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            echo 'Pizzas :  ' . $response->getBody();
        });
        $promise->wait();*/

        $res = $this->client->request('GET', 'http://pizzapi.herokuapp.com/pizzas',[]);
        echo $res->getBody();
    }

    public function commanderPizza(){

        $res = $this->client->request('POST', 'http://pizzapi.herokuapp.com/orders',
            [
                'json' => ['id' => 1]
            ]
        );

        echo $res->getBody();die;
    }
}