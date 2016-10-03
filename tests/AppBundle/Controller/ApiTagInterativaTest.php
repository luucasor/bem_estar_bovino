<?php

namespace Tests\AppBundle\Controller;

use PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;
use AppBundle\Model\Vaca;

class VacaControllerTest extends PHPUnit_Framework_TestCase
{
    private $client;
    private $base_uri = ['base_uri' => 'http://recrutamento.taginterativa.com.br/api/'];
    private $headers  = ['Accept'  => 'application/json', 'access-token' => '135448aee2'];
    private $idVacaAdicionada;

    public function setUp(){
      $this->client = new Client($this->base_uri);
    }

    public function testConexaoListagemVacas()
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
            foreach (json_decode($json, true) as $value) {
              $vaca = Vaca::getVacaObject($value);
              array_push($listaVacas, $vaca);
            }

            error_log($statusCode);
            $offset+=$limit;
        }


        foreach ($listaVacas as $vaca) {
          error_log($vaca->getWeight());
        }

        error_log("Tamanho Lista::: ".count($listaVacas));
        return $listaVacas;
    }

    public function listaVacas(){
      $method       = 'GET';
      $limit        = 2;
      $offset       = 0;
      $uri          = 'v1/cows';
      $listaVacas   = array();
      $codeResponse = 200;


      for ($i= 0; $codeResponse == 200 ; $i++) {
        $response = $this->client->request($method, $uri."?limit={$limit}&offset={$offset}", ['headers' => $this->headers]);

        if($response->getStatusCode() == 200){
          $json = $response->getBody();
          $vacas = Vaca::getVacaObjectList($json);
          array_push($listaVacas, $vacas);

          $offset+= $limit;
        }
        $codeResponse = $response->getStatusCode();
      }

      return $listaVacas;
    }
}
