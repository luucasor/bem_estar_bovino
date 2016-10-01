<<?php

class ConexaoApiTagInterativa {
  private $client;
  private $base_uri = ['base_uri' => 'http://recrutamento.taginterativa.com.br/api/'];
  private $headers  = ['Accept'  => 'application/json', 'access-token' => '135448aee2'];

  public function __construct(){
    $this->client = new Client($this->base_uri);
  }

  public function listarVacas(){
    $method     = 'GET';
    $uri        = 'v1/cows';

    $response = $this->client->request($method, $uri, ['headers' => $this->headers]);
    
  }
}
