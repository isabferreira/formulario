<?php

namespace App\usuarios;
require "../vendor/autoload.php";

use App\Controller\UserController;
use App\Model\Usuario;

$usuario = new Usuario();

$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';
switch($_SERVER["REQUEST_METHOD"]){
    case "POST";
    if (isset($body['email'])) {
        $usuario->setEmail($body['email']);
        $senha=$body['senha'];
        // $lembrar=$body['lembrar'];
        $usuariosController = new UserController($usuario);
        $resultado = $usuariosController->login($senha);
        if(!$resultado['status']){
            echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
           exit;
        }
        echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message'],'token'=>$resultado['token']]);
    }
    break;

        $resultado = $users->insert($body);
        echo json_encode(['status'=>$resultado]);
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