<?php

namespace App\usuarios;
require "../vendor/autoload.php";

use App\Controller\UserController;
use Firebase\JWT\JWT;
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
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        $usuariosController = new UserController($usuario);
        $validationResponse = $usuariosController->validarToken($token);
        if ($token === null || !$validationResponse['status']) {
            echo json_encode(['status' => false, 'message' => $validationResponse['message']]);
            exit;
        }
        echo json_encode(['status' => true, 'message' => 'Token válido']);
    exit;
   
break;  
}