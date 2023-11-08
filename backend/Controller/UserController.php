<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\Usuario;
use App\Model\Endereco;
use App\Controller\EnderecoController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
class UserController {

    private $db;
    private $usuarios;
    private $enderecos;
    private $controllerenderecos;

    public function __construct($user) {
        $this->db = new Model();
        $this->usuarios = $user;
        $this->enderecos = new Endereco();
        // $this->db->excluirTabelaEndereco();
        //  $this->db->criarTabelaEndereco();
    }
    public function select(){
        $user = $this->db->select('users');
        
        return  $user;
    }
    public function selectIdade(){
        $user = $this->db->select('idades');
        
        return  $user;
    }
    public function selectId($id){
        $user = $this->db->select('users',['id'=>$id]);
        
        return  $user;
    }
    public function insert($data){
        
        $this->usuarios->setNome($data['nome']);
        $this->usuarios->setEmail($data['email']);
        $this->usuarios->setDataNascimento($data['datanascimento']);
        $this->usuarios->setSenha($data['senha']);
        $resultado = $this->db->select("users", ['email' => $this->usuarios->getEmail()]);
        if ($resultado) {
             return false;
         }
        if($this->db->insert('users', [
            'nome'=>$this->usuarios->getNome(),
            'email'=>$this->usuarios->getEmail(),
            'datanascimento'=>$this->usuarios->getDataNascimento(),
            'senha'=>$this->usuarios->getSenha()])){
            $iduser=$this->db->getLastInsertId();
            $this->enderecos->setCep($data['cep']);
            $this->enderecos->setRua($data['rua']);
            $this->enderecos->setBairro($data['bairro']);
            $this->enderecos->setCidade($data['cidade']);
            $this->enderecos->setUf($data['uf']);
            $this->enderecos->setIduser($iduser);
            $this->controllerenderecos = new EnderecoController($this->enderecos);
           if ($this->controllerenderecos->insert()) {


            return true;
           } 
        }
       
    }
    public function update($newData,$condition){
        if($this->db->update('users', $newData, ['id'=>$condition])){
            return true;
        }
        return false;
    }
    public function delete( $conditions){
        if($this->db->delete('users', ['id'=>$conditions])){
            return true;
        }
        return false;
        
    }

    public function validarToken($token){
        
        $key = "123456789123456789";
        $algoritimo = 'HS256';
        try {
            $decoded = JWT::decode($token, new Key($key, $algoritimo));
            return ['status' => true, 'message' => 'Token válido!', 'data' => $decoded];
        } catch(Exception $e) {
            return ['status' => false, 'message' => 'Token inválido! Motivo: ' . $e->getMessage()];
        }
    }
    public function login($senha) {
        $resultado = $this->db->select("users", ['email' => $this->usuarios->getEmail()]);
        $checado = 3;
        if (!$resultado) {
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        if (!password_verify($senha,$resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        $key = "123456789123456789";
        $algoritimo='HS256';
            $payload = [
                "iss" => "localhost",
                "aud" => "localhost",
                "iat" => time(),
                "exp" => time() + (60 * $checado)
            ];
            
            $jwt = JWT::encode($payload, $key,$algoritimo);
           
        return ['status' => true, 'message' => 'Login bem-sucedido!','token'=>$jwt];
    }


}
