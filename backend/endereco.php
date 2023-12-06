<?php

namespace App\Endereco;

require "../vendor/autoload.php";

use App\Model\Endereco;
use App\Controller\EnderecoController;
use App\Model\Model;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: * ' );
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-cache, no-store, must-revalidate');

$endereco = new Endereco();
$bancodedados =  new Model();
$enderecos = new EnderecoController($endereco);
$data = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';
switch($_SERVER["REQUEST_METHOD"]){
    case "GET";
        if (!isset($_GET['id'])) {
            $resultado = $enderecos->select();
            echo json_encode(["endereco" => $resultado]);
        } else {
            $resultado = $enderecos->selectId($id);
            echo json_encode(["status" => true, "endereco" => $resultado[0]]);
            
        }
        break;
    case "POST":
        $endereco->setCep($data['cep']);
        $endereco->setRua($data['rua']);
        $endereco->setBairro($data['bairro']);
        $endereco->setCidade($data['cidade']);
        $endereco->setUf($data['uf']);
        $endereco->setIduser($data['getUserId']);
        $endereco->setLatitude($data['lagitude']);
        $endereco->setLongitude($data['longitude']);

        $enderecocontroller = new EnderecoController($endereco);
        $resultado = $enderecocontroller->insert();
        echo json_encode(['status'=>$resultado]);
        break;
    case "DELETE":
        $resultado = $bancodedados->delete("endereco", ["id"=>intval($_GET["id"])]);
        echo json_encode(['status'=>$resultado]);
        break;
}
