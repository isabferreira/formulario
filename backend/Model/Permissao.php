<?php
namespace App\Model;

class Permissao {
    private int $id;
    private string $nome;

    public function getNome(){
        return $this->nome;
    }
    public function getId(){
        return $this->id;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function setId($id){
        $this->id = $id;
    }
}