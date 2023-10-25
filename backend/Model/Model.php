<?php
namespace App\Model;
use Exception;
use PDO;
use PDOException;

class Model {
 private $host = "localhost";
 private $db_name = "test_drive";
 private $username = "root";
 private $password = "root123";
 private $conn;
 private $db_type = "sqlite"; // Opções: "mysql", "pgsql", "sqlite", "mssql"

 public function __construct() {
     $this->connect();
     $this->criarTabelaEndereco();
     $this->criarTabelaVendas();
     $this->criarViewProdutosPorUsuario();
 }

 private function connect() {
  $this->conn = null;

  try {
    switch ($this->db_type) {
        case "mysql":
          $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            break;
        case "pgsql":
            $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->db_name;
            break;
        case "sqlite":
            $dsn = "sqlite:" . "sqlite/test_drive.db";
            $filepath =  "sqlite/test_drive.db";
            if (!file_exists($filepath)) {
                die("Arquivo não encontrado: $filepath");
            }
            break;
        case "mssql":
           $dsn = "sqlsrv:Server=" . $this->host . ";Database=" . $this->db_name;
           break;
        default:
            throw new Exception("Database type not supported.");
      }
      if ($this->db_type == "sqlite") {
        $this->conn = new PDO($dsn);
    } else {
        $this->conn = new PDO($dsn, $this->username, $this->password);
    }
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

public function getLastInsertId() {
    return $this->conn->lastInsertId();
}

public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(function($item) {
            return ":$item"; 
        }, array_keys($data)));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
}

public function select($table, $conditions = []) {
        $query = "SELECT * FROM $table";
        if (!empty($conditions)) {
            $conditionsStr = implode(" AND ", array_map(function($item) {
            return "$item = :$item";
            }, array_keys($conditions)));
            $query .= " WHERE $conditionsStr";
        }
        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function update($table, $data, $conditions) {
        $dataStr = implode(", ", array_map(function($item) {
            return "$item = :$item"; 
        }, array_keys($data)));
        $conditionsStr = implode(" AND ", array_map(function($item) { 
            return "$item = :condition_$item"; 
        }, array_keys($conditions)));
        $query = "UPDATE $table SET $dataStr WHERE $conditionsStr";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":condition_$key", $value);
        }
   return $stmt->execute();
}

public function delete($table, $conditions) {
        $conditionsStr = implode(" AND ", array_map(function($item) {
            return "$item = :$item"; 
        }, array_keys($conditions)));
        $query = "DELETE FROM $table WHERE $conditionsStr";
        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
}

public function deleteWithCustomCondition($table, $condition) {
        $query = "DELETE FROM $table WHERE $condition";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
}

public function criarTabelaEndereco(){
    $sql = "
    CREATE TABLE IF NOT EXISTS endereco (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cep TEXT NOT NULL,
        rua TEXT NOT NULL,
        bairro TEXT NOT NULL,
        cidade TEXT NOT NULL,
        uf TEXT NOT NULL,
        iduser INTEGER,
        FOREIGN KEY (iduser)
        REFERENCES users (id) ON DELETE CASCADE
    )";
    $this->conn->exec($sql);    
}

public function ExcluirTabelaEndereco(){
    $sql = "DROP TABLE endereco";
    $this->conn->exec($sql);
}

public function criarTabelaVendas(){
    $sql = "
    CREATE TABLE IF NOT EXISTS vendas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_usuario INTEGER,
        id_produto INTEGER,
        data_cadastro DATE,
        FOREIGN KEY (id_usuario) REFERENCES users(id),
        FOREIGN KEY (id_produto) REFERENCES produtos(id)
    )";
    $this->conn->exec($sql);
}

public function criarViewProdutosPorUsuario(){
    $sql = "
    CREATE VIEW IF NOT EXISTS produtos_por_usuario AS
    SELECT u.id, u.nome, COUNT(v.id_produto) as quantidade_produtos
    FROM users u
    LEFT JOIN vendas v ON u.id = v.id_usuario
    GROUP BY u.id";
    $this->conn->exec($sql);
}
}