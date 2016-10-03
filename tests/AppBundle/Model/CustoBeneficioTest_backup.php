<?php

namespace Tests\AppBundle\Model;

use PHPUnit_Framework_TestCase;
use AppBundle\Model\Vaca;

class CustoBeneficioTest extends PHPUnit_Framework_TestCase{

  private $vaca;

  private $kgPastoPor100kgVaca = 3;
  private $precoKgPasto = 0.20;
  private $mes = 30;
  private $ano = 365;

  public function setUp(){
    $this->vaca = new Vaca(550, 10, 2000);
  }

  public function testQuantidadePastoMes(){
    $quantidadePastoDiario = ($this->vaca->getWeight() / 100) * $this->kgPastoPor100kgVaca;
    $custoPastoDiario      = $quantidadePastoDiario * $this->precoKgPasto;
    $custoPastoMes         = $custoPastoDiario * $this->mes;

    $this->assertEquals(99, $custoPastoMes);
  }

  public function testCustoAnual(){
    $quantidadePastoDiario = ($this->vaca->getWeight() / 100) * $this->kgPastoPor100kgVaca;
    $custoPastoDiario      = $quantidadePastoDiario * $this->precoKgPasto;
    $custoPastoAnual       = $custoPastoDiario * $this->ano;

    $this->assertEquals(1204.5, $custoPastoAnual);
  }

  public function testMelhorVaca(){
    $quantidadePastoDiario = ($this->vaca->getWeight() / 100) * $this->kgPastoPor100kgVaca;
    $custoPastoDiario      = $quantidadePastoDiario * $this->precoKgPasto;
    $custoPastoAnual       = $custoPastoDiario * $this->ano;


    $vidaRestante   = (20 - $this->vaca->getAge());
    $custoPastoVida = $custoPastoAnual * $vidaRestante;
    $custoTotal     = $this->vaca->getPrice() + $custoPastoVida;

    $resultado      = $vidaRestante * $this->ano;
    $custoBeneficio = $custoTotal / $resultado;


    $this->assertEquals(3.8479452054794518, $custoBeneficio);
  }

}
