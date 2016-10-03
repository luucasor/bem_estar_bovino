<?php

namespace AppBundle\Model;

use AppBundle\Utils\GerenciadorCusto;

class Vaca {

  private $id;
  private $weight;
  private $age;
  private $price;
  public $gerenciadorCusto;

  public function __construct($weight, $age, $price){
    $this->weight          = $weight;
    $this->age             = $age;
    $this->price           = $price;
    $this->gerenciadorCusto = new GerenciadorCusto($this);
  }

  public function setId($valor){
    $this->id = $valor;
  }

  public function getId(){
    return $this->id;
  }

  public function getWeight(){
    return $this->weight;
  }

  public function setWeight($valor){
    $this->weight = $valor;
  }

  public function getAge(){
    return $this->age;
  }

  public function setAge($valor){
    $this->age = $valor;
  }

  public function getPrice(){
    return $this->price;
  }

  public function setPrice($valor){
    $this->price = $valor;

  }
  //Código do Wrikken :: http://stackoverflow.com/questions/6836592/serializing-php-object-to-json
  function getJsonData(){
    $var = get_object_vars($this);
    foreach ($var as &$value) {
        if (is_object($value) && method_exists($value,'getJsonData')) {
            $value = $value->getJsonData();
        }
    }
    return $var;
  }

  public static function getVacaObject($stdObject){
    $vaca = new Vaca($stdObject['weight'], $stdObject['age'], $stdObject['price']);
    $vaca->setId($stdObject['id']);
    return $vaca;
  }

  public static function getVacaObjectList($json){
    $stdObjectList = json_decode($json);
    $listaVacas    = array();

    foreach ($stdObjectList as $stdVaca) {
      $vaca = new Vaca($stdVaca->{'weight'}, $stdVaca->{'age'}, $stdVaca->{'price'});
      $vaca->setId($stdVaca->{'id'});
      array_push($listaVacas, $vaca);
    }

    return $listaVacas;
  }
}
