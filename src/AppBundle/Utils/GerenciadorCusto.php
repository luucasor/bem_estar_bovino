<?php

namespace AppBundle\Utils;

use AppBundle\Model\Vaca;

class GerenciadorCusto {

  private $vaca;
  private $kgPastoPor100kgVaca = 3;
  private $precoKgPasto = 0.20;
  private $mes = 30;
  private $ano = 365;
  private $mediaVida = 20;
  private $diasDeTrabalhoNoAno = 365;

  public function __construct($vaca){
    $this->vaca = $vaca;
  }

  public function custoPastoMensal(){
    return $this->custoPastoDiario() * $this->mes;
  }

  public function custoPastoAnual(){
    return $this->custoPastoDiario() * $this->ano;
  }

  public function custoBeneficio(){
    return $this->custoTotal() / $this->diasComoMascote();
  }

  public static function melhorVaca($vacas){
    $melhorVaca = new Vaca(INF, 20, INF);

    foreach ($vacas as $vaca) {
      if($vaca->getCustoBeneficio() < $melhorVaca->getCustoBeneficio())
          $melhorVaca = $vaca;
    }

    return $melhorVaca;
  }

  private function custoPastoDiario(){
    $quantidadePastoDiario = ($this->vaca->getWeight() / 100) * $this->kgPastoPor100kgVaca;
    return $quantidadePastoDiario * $this->precoKgPasto;
  }

  private function vidaRestante(){
    $restante = $this->mediaVida - $this->vaca->getAge();
    return $restante == 0 ? 1 : $restante;
  }

  private function custoTotal(){
    $custoPastoVidaRestante  = $this->custoPastoAnual() * $this->vidaRestante();
    return $this->vaca->getPrice() + $custoPastoVidaRestante;
  }

  private function diasComoMascote(){
    return $this->vidaRestante() * $this->diasDeTrabalhoNoAno;
  }
}
