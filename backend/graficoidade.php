<?php

namespace App\usuarios;
require "../vendor/autoload.php";

use App\Controller\UserController;

$users = new UserController();

$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';
switch($_SERVER["REQUEST_METHOD"]){
    case "GET";
            $resultado = $users->selectIdade();
            if(!is_array($resultado)){
                echo json_encode(["status"=>false]);
                exit;
            }
            echo json_encode(["status"=>true,"idades"=>$resultado]);
       
    break;
  
}