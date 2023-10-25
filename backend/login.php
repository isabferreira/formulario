<?php
require '../vendor/autoload.php';  

use Firebase\JWT\JWT;
use App\Model\Model;
use App\Model\Usuario;
use App\Controller\UserController;
$algoritimo='HS256';
$model = new Model();
$usuario = new Usuario();
$model -> criarTabelaToken();
$usercontroller = new UserController();
$ipautorizado = ['::1', '123.123.123.124'];
if (!in_array($_SERVER['REMOTE_ADDR'], $ipautorizado)) {
    echo json_encode(['error' => 'Acesso não autorizado'], 403);
    exit;
}

//$secretKey = bin2hex(openssl_random_pseudo_bytes(16))
$secretKey = "5555555538975187454316875";
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    $password = $data['password'];
    
    $usuario->setEmail($username);
    $usuario->setSenha($password);

    $data = $model->select('users', ['email' => $username]);
    if (!$data) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno do servidor.']);
        exit;
    }
    if (!empty($data) && password_verify($password, $data[0]['senha'])) {
        $usuario->setId($data[0]['id']);

        $payload = [
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            "exp" => time() + (60 * 3),  
            "data" => [
                "userId" => $usuario->getId(),
                "username" => $usuario->getNome(),
            ]
        ];
        

        $jwt = JWT::encode($payload, $secretKey, $algoritimo);
        $model->insert('token', ['id_user' => $usuario->getId(),'token'=> $jwt]);
        echo json_encode(['token' => $jwt]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Email ou senha inválidos.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Requisição inválida.']);
}
