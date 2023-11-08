<?php

namespace App\usuarios;
require "../vendor/autoload.php";

use App\Controller\UserController;
use App\Model\Usuario;

$usuario = new Usuario();
$users = new UserController($usuario);

$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';
switch($_SERVER["REQUEST_METHOD"]){
    case "POST";
        $resultado = $users->insert($body);
        if($resultado){
            echo json_encode(['status' => true, 'message' => 'Usuário inserido.']);
        }else{
            echo json_encode(['status' => false, 'message' => 'Usuário já existe.']);
        }
        
    break;
    case "GET";
        if(!isset($_GET['id'])){
            $resultado = $users->select();
            echo json_encode(["usuarios"=>$resultado]);
        }else{
            $resultado = $users->selectId($id);
            echo json_encode(["status"=>true,"usuario"=>$resultado[0]]);
        }
       
    break;
    case "PUT";
        $resultado = $users->update($body,intval($_GET['id']));
        echo json_encode(['status'=>$resultado]);
    break;
    case "DELETE";
        $resultado = $users->delete(intval($_GET['id']));
        echo json_encode(['status'=>$resultado]);
    break;  
}