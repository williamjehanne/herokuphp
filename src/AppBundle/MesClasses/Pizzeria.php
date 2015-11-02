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
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://pizzapi.herokuapp.com/pizzas');
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            echo 'I completed! ' . $response->getBody();
        });
        $promise->wait();
    }
}