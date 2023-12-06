<?php

namespace App\Model;

class Endereco{
  private $cep;
    private $rua;
    private $bairro;
    private $cidade;
    private $uf;
    private $iduser;
    private $latitude;
    private $longitude;

    public function __construct() {
      
    }

    public function getCep() {
      return $this->cep;
    }
    public function setCep($cep): self{
      $this->cep = $cep;
      return $this;
    }
    
    public function getRua() {
      return $this->rua;
    }
    public function setRua($rua): self{
      $this->rua = $rua;
      return $this;
    }
    public function getBairro() {
      return $this->bairro;
    }
    public function setBairro($bairro): self{
      $this->bairro = $bairro;
      return $this;
    }
    public function getCidade() {
      return $this->cidade;
    }
    public function setCidade($cidade): self{
      $this->cidade = $cidade;
      return $this;
    }
    public function getUf() {
      return $this->uf;
    }
    public function setUf($uf): self{
      $this->uf = $uf;
      return $this;
    }
    public function getIduser() {
      return $this->iduser;
    }
    public function setIduser($iduser): self {
      $this->iduser = $iduser;
      return $this;
    }

    public function getLatitude() {
      return $this->latitude;
    }
    public function setLatitude($latitude): self{
      $this->latitude = $latitude;
      return $this;
    }
    public function getLongitude() {
      return $this->longitude;
    }
    public function setLongitude($longitude): self{
      $this->longitude = $longitude;
      return $this;
    }
}


