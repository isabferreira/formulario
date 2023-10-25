<?php

namespace App\Model;

class Endereco{
  private $cep;
    private $rua;
    private $bairro;
    private $cidade;
    private $uf;
    private $iduser;

    public function __construct() {
      
    }

    public function getCep() {
      return $this->cep;
    }
    public function setCep($cep) {
      $this->cep = $cep;
    }
    
    public function getRua() {
      return $this->rua;
    }
    public function setRua($rua) {
      $this->rua = $rua;
    }
    public function getBairro() {
      return $this->bairro;
    }
    public function setBairro($bairro) {
      $this->bairro = $bairro;
    }
    public function getCidade() {
      return $this->cidade;
    }
    public function setCidade($cidade) {
      $this->cidade = $cidade;
    }
    public function getUf() {
      return $this->uf;
    }
    public function setUf($uf) {
      $this->uf = $uf;
    }
    public function getIduser() {
      return $this->iduser;
    }
    public function setIduser($iduser) {
      $this->iduser = $iduser;
    }
}


