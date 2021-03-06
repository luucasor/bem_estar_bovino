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
  private $logger;

  public function __construct(){
    $this->client = new Client($this->base_uri);
    $this->logger = new Logger('logger');
    $this->logger->pushHandler(new StreamHandler('logger.log', Logger::DEBUG));
  }

  public function adicionaVaca($vaca){
    $method     = 'POST';
    $uri        = 'v1/cows';
    $body = $vaca->getJsonData();

    $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

    $json = $response->getBody();
    $vaca = Vaca::getVacaObjectByJson($json);
    $this->logger->info('Api.adicionaVaca.response:: '.print_r($vaca,1));
    return $vaca;
  }

  public function buscaVaca($id){
    $method     = 'GET';
    $uri        = 'v1/cows/'.$id;
    $response = $this->client->request($method, $uri, ['headers' => $this->headers]);


    $json = $response->getBody();
    $vaca = Vaca::getVacaObjectByJson($json);
    $this->logger->info('Api.buscaVaca.response:: '.print_r($vaca,1));
    return $vaca;
  }

  public function editaVaca($vaca){
    $method     = 'PUT';
    $uri        = 'v1/cows/'.$vaca->getId();

    $body = $vaca->getJsonData();
    $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

    $json = $response->getBody();
    $vaca = Vaca::getVacaObjectByJson($json);
    $this->logger->info('Api.editaVaca.response:: '.print_r($vaca,1));
    return $vaca;
  }

  public function removeVaca($id){
    $method     = 'DELETE';
    $uri        = 'v1/cows/'.$id;

    $json = $this->client->request($method, $uri, ['headers' => $this->headers]);
    $this->logger->info('Api.removeVaca.response:: '.print_r($json,1));

    return $json->getStatusCode();
  }

  public function listaVacas()
  {
      $method       = 'GET';
      $uri          = 'v1/cows';
      $listaVacas   = array();
      $statusCode   = 200;
      $offset       = 0;
      $limit        = 7;

      while ($statusCode == 200) {
          $response = $this->client->request($method, $uri."?limit=".$limit."&offset=".$offset, ['headers' => $this->headers]);
          $statusCode = $response->getStatusCode();

          if($statusCode == 204) break;

          $json = $response->getBody();
          $stdObjectList = json_decode($json);

          foreach($stdObjectList as $stdObject) {
            $vaca = Vaca::getVacaObjectByStd($stdObject);
            array_push($listaVacas, $vaca);
          }

          $offset+=$limit;
      }

      return $listaVacas;
  }
}
