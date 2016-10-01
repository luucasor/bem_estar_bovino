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
        $method     = 'GET';
        $uri        = 'v1/cows';

        $response = $this->client->request($method, $uri, ['headers' => $this->headers]);

        $json = $response->getBody();
        $listaVacas = Vaca::getVacaObjectList($json);

        foreach ($listaVacas as $vaca) {
          error_log($vaca->getId());
          error_log($vaca->getWeight());
          error_log($vaca->getAge());
          error_log($vaca->getPrice());
          error_log("----------------");
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

     public function testAdicionarNovaVaquinha(){
       $method     = 'POST';
       $uri        = 'v1/cows';

       $vaca = new Vaca(650, 9, 798.00);
       $body = $vaca->getJsonData();
       $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

       $json = $response->getBody();
       $vaca = Vaca::getVacaObject($json);

       $this->assertNotEquals(null, $vaca->getId());
       error_log('ID Retornado: '.$vaca->getId());
     }

     public function testRecuperarDadosDeUmaVaquinhaExistente(){

       $idVaca     = 291;
       $method     = 'GET';
       $uri        = 'v1/cows/'.$idVaca;

       $response = $this->client->request($method, $uri, ['headers' => $this->headers]);

       $json = $response->getBody();
       $vaca = Vaca::getVacaObject($json);

       $this->assertEquals($idVaca, $vaca->getId());
     }

     public function testAtualizarDadosDeUmaVaquinhaExistente(){
       $idVaca     = 291;
       $weight     = 680;
       $method     = 'PUT';
       $uri        = 'v1/cows/'.$idVaca;

       $vaca = new Vaca($weight, 10, 1000.00);
       $vaca->setId($idVaca);

       $body = $vaca->getJsonData();
       $response = $this->client->request($method, $uri, ['headers' => $this->headers,'form_params' => $body]);

       $json = $response->getBody();
       $vaca = Vaca::getVacaObject($json);

       error_log("----------------");
       error_log("-------PUT------");
       error_log($vaca->getId());
       error_log($vaca->getWeight());
       error_log($vaca->getAge());
       error_log($vaca->getPrice());
       error_log("----------------");
       $this->assertEquals($weight, $vaca->getWeight());

     }

     public function testRemoverDadosDaVaquinha(){
       $id         = 274;
       $method     = 'DELETE';
       $uri        = 'v1/cows/'.$id;

       $response = $this->client->request($method, $uri, ['headers' => $this->headers]);

       $json = $response->getBody();
       $stdObject = json_decode($json);

       if(isset($stdObject->{'success'}))
         error_log($stdObject->{'success'});

       if(isset($stdObject->{'error'}))
         error_log($stdObject->{'error'});

       $this->assertEquals(true, $stdObject->{'success'});
     }

}
