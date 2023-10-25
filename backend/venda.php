<?php
namespace App\venda;

require "../vendor/autoload.php";

use App\Controller\VendaController;

$vendaController = new VendaController();

$body = json_decode(file_get_contents('php://input'), true);

$id = isset($_GET['id']) ? $_GET['id'] : '';

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $resultado = $vendaController->insert($body);
        echo json_encode(['status' => $resultado]);
        break;
    case "GET":
        $resultado = $vendaController->selectprodId($body);
        echo json_encode(['status' => $resultado]);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => false, 'message' => 'Método não permitido']);
        break;
}
?>
