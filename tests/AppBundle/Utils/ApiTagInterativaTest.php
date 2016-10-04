<?php

namespace Tests\AppBundle\Utils;

use PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;
use AppBundle\Model\Vaca;
use AppBundle\Utils\ApiTagInterativa;

class ApiTagInterativaTest extends PHPUnit_Framework_TestCase
{
    private $client;
    private $base_uri = ['base_uri' => 'http://recrutamento.taginterativa.com.br/api/'];
    private $headers  = ['Accept'  => 'application/json', 'access-token' => '135448aee2'];
    private $idUltimaVaquinhaAdicionada;
    private $dao;

    public function setUp(){
      $this->client = new Client($this->base_uri);
      $this->dao    = new ApiTagInterativa();
    }

    public function testAdicionaVaquinha(){
      $vaca = new Vaca(650, 9, 798.00);
      $vaca = $this->dao->adicionaVaca($vaca);
      $this->assertNotEquals(null, $vaca->getId());
    }

    public function testRecuperarDadosDeUmaVaquinhaExistente(){
      $vaca = new Vaca(300, 2, 600.00);
      $vaca = $this->dao->adicionaVaca($vaca);

      $vacaEncontrada = $this->dao->buscaVaca($vaca->getId());
      $this->assertEquals($vaca->getId(), $vacaEncontrada->getId());
    }


    public function testConexaoListagemVacas()
    {
      $listaVacas = $this->dao->listaVacas();
      $this->assertNotEquals(null, count($listaVacas));
    }

    public function testAtualizarDadosDaVaquinha()
    {
      $vaca = new Vaca(550, 9, 798.00);
      $vaca = $this->dao->adicionaVaca($vaca);

      $newWeight = 600;
      $vaca->setWeight($newWeight);

      $vacaEditada = $this->dao->editaVaca($vaca);
      $this->assertEquals($newWeight, $vacaEditada->getWeight());
    }

    public function testRemoverDadosDaVaquinha(){
      $vaca = new Vaca(800, 10, 1000.00);
      $vaca = $this->dao->adicionaVaca($vaca);

      $statusCode = $this->dao->removeVaca($vaca->getId());
      $this->assertEquals(200, $statusCode);
    }
}
