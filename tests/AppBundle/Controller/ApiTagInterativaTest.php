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
          $stdObjectList = json_decode($json);

          foreach($stdObjectList as $stdObject) {
            $vaca = Vaca::getVacaObject($stdObject);
            array_push($listaVacas, $vaca);
          }

          $offset+=$limit;
      }

      $this->assertEquals(22, count($listaVacas));
    }
}
