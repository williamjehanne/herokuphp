<?php

/**
 * Created by PhpStorm.
 * User: jordan
 * Date: 02/11/2015
 * Time: 11:02
 */

namespace AppBundle\MesClasses;

use GuzzleHttp;
use Symfony\Component\Config\Definition\Exception\Exception;

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

        try{
            $res = $this->client->request('GET', 'http://pizzapi.herokuapp.com/pizzas',['timeout' => 30]);
            $corpsReponse = $res->getBody();
            echo $corpsReponse;

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
            die;
        }catch(\Exception $e){
            echo "Beaucoup de commande en ce moment !";
        }
    }

}