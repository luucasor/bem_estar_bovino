<?php

namespace Tests\AppBundle\Model;

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
    $this->assertEquals(99, $this->gerenciadorCusto->custoPastoMensal());
  }

  public function testCustoAnual(){
    $this->assertEquals(1204.5, $this->gerenciadorCusto->custoPastoAnual());
  }

  public function testCustoBeneficio(){
    $this->assertEquals(3.8479452054794518, $this->gerenciadorCusto->custoBeneficio());
  }

  public function testMelhorVacaPorPeso(){
    $vaca1 = new Vaca(450, 10, 2000);
    $vaca2 = new Vaca(550, 10, 2000);
    $vaca3 = new Vaca(650, 10, 2000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Peso------");
    error_log("\nGanhadora:::  ".$melhorVaca->getCustoBeneficio());
    error_log("Peso:::  ".$melhorVaca->getWeight());
  }

  public function testMelhorVacaPorIdade(){
    $vaca1 = new Vaca(450, 1, 2000);
    $vaca2 = new Vaca(450, 5, 2000);
    $vaca3 = new Vaca(450, 10, 2000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Idade------");
    error_log("\nGanhadora:::  ".$melhorVaca->getCustoBeneficio());
    error_log("Idade:::  ".$melhorVaca->getAge());
  }

  public function testMelhorVacaPorPreco(){
    $vaca1 = new Vaca(450, 10, 1000);
    $vaca2 = new Vaca(450, 10, 2000);
    $vaca3 = new Vaca(450, 10, 3000);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Preco------");
    error_log("\nGanhadora:::  ".$melhorVaca->getCustoBeneficio());
    error_log("Preco:::  ".$melhorVaca->getPrice());
  }

  public function testMelhorVacaVariada(){
    $vaca1 = new Vaca(450, 10, 1000);
    $vaca2 = new Vaca(150, 15, 1000);
    $vaca3 = new Vaca(650, 1, 1500);

    $vacas = array( $vaca1, $vaca2, $vaca3 );
    $melhorVaca = GerenciadorCusto::melhorVaca($vacas);
    error_log("\n-------Variada------");
    error_log("\nGanhadora:::  ".$melhorVaca->getCustoBeneficio());
    error_log("Valores:::  ".$melhorVaca->getWeight()." | ".$melhorVaca->getAge()." | ".$melhorVaca->getPrice());
  }

}
