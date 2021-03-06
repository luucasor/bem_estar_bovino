<?php

namespace Tests\AppBundle\Utils;

use PHPUnit_Framework_TestCase;
use AppBundle\Model\Vaca;
use AppBundle\Utils\GerenciadorCusto;

class GerenciadorCustoTest extends PHPUnit_Framework_TestCase{

  private $gerenciadorCusto;

  public function setUp(){
    $vaca = new Vaca(550, 10, 2000);
    $this->gerenciadorCusto = new GerenciadorCusto($vaca);
  }

  public function testCustoPastoMes(){
    $this->assertEquals(99, $this->gerenciadorCusto->pastoMensal);
  }

  public function testCustoAnual(){
    $this->assertEquals(1204.5, $this->gerenciadorCusto->pastoAnual);
  }

  public function testCustoBeneficio(){
    $this->assertEquals(3.8479452054794518, $this->gerenciadorCusto->custoBeneficio);
  }

  public function testMelhorVacaPorPeso(){
    $vaca1 = new Vaca(450, 10, 2000);
    $vaca2 = new Vaca(550, 10, 2000);
    $vaca3 = new Vaca(650, 10, 2000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Peso------");
    error_log("\nGanhadora:::  ".$melhorVaca->gerenciadorCusto->custoBeneficio);
    error_log("Peso:::  ".$melhorVaca->getWeight());

    $this->assertEquals(3.2479452054795, $melhorVaca->gerenciadorCusto->custoBeneficio);
  }

  public function testMelhorVacaPorIdade(){
    $vaca1 = new Vaca(450, 1, 2000);
    $vaca2 = new Vaca(450, 5, 2000);
    $vaca3 = new Vaca(450, 10, 2000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Idade------");
    error_log("\nGanhadora:::  ".$melhorVaca->gerenciadorCusto->custoBeneficio);
    error_log("Idade:::  ".$melhorVaca->getAge());
    $this->assertEquals(2.9883922134102, $melhorVaca->gerenciadorCusto->custoBeneficio);
  }

  public function testMelhorVacaPorPreco(){
    $vaca1 = new Vaca(450, 10, 1000);
    $vaca2 = new Vaca(450, 10, 2000);
    $vaca3 = new Vaca(450, 10, 3000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Preco------");
    error_log("\nGanhadora:::  ".$melhorVaca->gerenciadorCusto->custoBeneficio);
    error_log("Preco:::  ".$melhorVaca->getPrice());
    $this->assertEquals(2.9739726027397, $melhorVaca->gerenciadorCusto->custoBeneficio);
  }

  public function testMelhorVacaVariada(){
    $vaca1 = new Vaca(450, 10, 1000);
    $vaca2 = new Vaca(150, 15, 1000);
    $vaca3 = new Vaca(650, 1, 1500);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Variada------");
    error_log("\nGanhadora:::  ".$melhorVaca->gerenciadorCusto->custoBeneficio);
    error_log("Valores:::  ".$melhorVaca->getWeight()." | ".$melhorVaca->getAge()." | ".$melhorVaca->getPrice());
    $this->assertEquals(1.4479452054795, $melhorVaca->gerenciadorCusto->custoBeneficio);
  }

}
