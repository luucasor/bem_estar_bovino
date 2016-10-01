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

    public function setUp(){
      $this->client = new Client($this->base_uri);
    }

    public function testConexaoListagemVacas()
    {
        $method     = 'GET';
        $uri        = 'v1/cows';

        $response = $this->client->request($method, $uri, ['headers' => $this->headers]);

        $json = $response->getBody();
        $listaVacas = Vaca::getVacaObjectList($json);

        foreach ($listaVacas as $vaca) {
          error_log($vaca->getWeight());
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

    // public function testAdicionarNovaVaquinha(){
    //   $method     = 'POST';
    //   $uri        = 'v1/cows';
    //
    //   $vaca = new Vaca(650, 9, 798.00);
    //   $body = $vaca->getJsonData();
    //   $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);
    //
    //   $json = $response->getBody();
    //   $vaca = Vaca::getVacaObject($json);
    //
    //   $this->assertNotEquals(null, $vaca->getId());
    //   error_log('ID Retornado: '.$vaca->getId());
    // }

}
