<?php

namespace App\Controller;

use App\Model\Model;

class VendaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function insert($data)
    {
        $idusuario = $data['idusuario'];
        $idproduto = $data['idproduto'];
        $data_cadastro = date('Y-m-d H:i:s');

        try {
            $this->model->insert('vendas', ['id_usuario' => $idusuario, 'id_produto' => $idproduto, 'data_cadastro' => $data_cadastro]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function selectprodId()
    {
        $user = $this->model->select('produtos_por_usuario');
        return $user;
    }
}
