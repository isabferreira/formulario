<?php

namespace App\Controller;

use App\Model\Model;

class ProdutoController {

    private $db;

    public function __construct() {
        $this->db = new Model();
    }
    public function select(){
        $user = $this->db->select('produtos');
        
        return  $user;
    }
    public function selectId($id){
        $user = $this->db->select('produtos',['id'=>$id]);
        
        return  $user;
    }
    public function insert($data){
        if($this->db->insert('produtos', $data)){
            return true;
        }
        return false;
    }
    public function update($newData,$conditions){
        if($this->db->update('produtos', $newData, ['id'=>$conditions])){
            return true;
        }
        return false;
    }
    public function delete( $conditions){
        if($this->db->delete('produtos' , ['id'=>$conditions])){
            return true;
        }
        return false;

    }
}
