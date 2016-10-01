<?php

namespace AppBundle\Utils;

use AppBundle\Model\Vaca;
use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApiTagInterativa {

  private $client;
  private $base_uri = ['base_uri' => 'http://recrutamento.taginterativa.com.br/api/'];
  private $headers  = ['Accept'  => 'application/json', 'access-token' => '135448aee2'];

  public function __construct(){
    $this->client = new Client($this->base_uri);
  }

  public function adicionaVaca($vaca){
    $method     = 'POST';
    $uri        = 'v1/cows';
    $body = $vaca->getJsonData();

    $logger = new Logger('logger');
    $logger->pushHandler(new StreamHandler('logger.log', Logger::DEBUG));

    $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

    $json = $response->getBody();
    $vaca = Vaca::getVacaObject($json);
    $logger->info('response:: '.print_r($vaca,1));
    return $vaca;
  }

  public function buscaVaca($id){
    $method     = 'GET';
    $uri        = 'v1/cows/'.$id;
    $response = $this->client->request($method, $uri, ['headers' => $this->headers]);


    $json = $response->getBody();
    return Vaca::getVacaObject($json);
  }

  public function editaVaca($vaca){
    $method     = 'PUT';
    $uri        = 'v1/cows/'.$vaca->getId();

    $body = $vaca->getJsonData();
    $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

    $json = $response->getBody();
    $vaca = Vaca::getVacaObject($json);
  }

  public function removeVaca($id){
    $method     = 'DELETE';
    $uri        = 'v1/cows/'.$id;

    $json = $this->client->request($method, $uri, ['headers' => $this->headers]);

    return $json;
  }

  public function listaVacas(){
    $method     = 'GET';
    $uri        = 'v1/cows';

    $response = $this->client->request($method, $uri, ['headers' => $this->headers]);
    $json = $response->getBody();

    return Vaca::getVacaObjectList($json);
  }
}
