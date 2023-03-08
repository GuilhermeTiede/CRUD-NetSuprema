<?php
require_once 'Pessoa.php';
require_once 'Telefone.php';
class TelefoneController {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createTelefone($telefone, $descricao, $pessoa_id) {
        $sql = "INSERT INTO telefone (telefone, descricao, pessoa_id) VALUES (:telefone, :descricao, :pessoa_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':pessoa_id', $pessoa_id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function readTelefones($pessoa_id) {
        $sql = "SELECT * FROM telefone WHERE pessoa_id = :pessoa_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':pessoa_id', $pessoa_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTelefone($id, $telefone, $descricao) {
        $sql = "UPDATE telefone SET telefone = :telefone, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteTelefone($id) {
        $sql = "DELETE FROM telefone WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
