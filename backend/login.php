<?php

namespace App\usuarios;
require "../vendor/autoload.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: * ' );
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-cache, no-store, must-revalidate');

use App\Controller\UserController;
use App\Model\Usuario;

$usuario = new Usuario();
$usuariosController = new UserController();
$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';

switch($_SERVER["REQUEST_METHOD"]){
    case "POST";
    if (isset($body['email'])) {
        $email = $body['email'];
        $senha=$body['senha'];
        // $lembrar=$body['lembrar'];
       
        $resultado = $usuariosController->login($senha,$email);
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
    $usuariosController = new UserController();
    $validationResponse = $usuariosController->validarToken($token);
    if ($token === null || !$validationResponse['status']) {
        echo json_encode($validationResponse);
        exit;
    }
    echo json_encode($validationResponse);
    exit;
       
    break;
}