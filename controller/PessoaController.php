<?php

require_once 'model/Pessoa.php';
require_once 'model/Telefone.php';

class PessoaController {

    private $conn;

    public function __construct() {
        $this->conn = new PDO('pgsql:host=localhost;dbname=NetSuprema', 'postgre', '190600');
    }

    public function cadastrarPessoa($nome, $cpf, $endereco, $telefone, $descricaoTelefone) {
        try {
            $this->conn->beginTransaction();

            // cadastra a pessoa
            $pessoa = new Pessoa($nome, $cpf, $endereco);
            $pessoa->cadastrar($this->conn);

            // cadastra o telefone da pessoa
            $telefone = new Telefone($telefone, $descricaoTelefone);
            $telefone->cadastrar($this->conn, $pessoa->getId());

            $this->conn->commit();

            return 'ok';
        } catch (PDOException $e) {
            $this->conn->rollback();

            return 'Erro ao cadastrar pessoa: ' . $e->getMessage();
        }
    }

    public function listarPessoas() {
        $query = 'SELECT * FROM pessoa';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pessoa = new Pessoa($row['nome'], $row['cpf'], $row['endereco']);
            $pessoa->setId($row['id']);

            $query = 'SELECT * FROM telefone WHERE id_pessoa = :id_pessoa';
            $stmtTelefone = $this->conn->prepare($query);
            $stmtTelefone->bindValue(':id_pessoa', $pessoa->getId());
            $stmtTelefone->execute();

            while ($rowTelefone = $stmtTelefone->fetch(PDO::FETCH_ASSOC)) {
                $telefone = new Telefone($rowTelefone['numero'], $rowTelefone['descricao']);
                $pessoa->addTelefone($telefone);
            }

            $result[] = $pessoa;
        }

        return $result;
    }

    public function excluirPessoa($idPessoa) {
        try {
            $this->conn->beginTransaction();

            // exclui os telefones da pessoa
            $query = 'DELETE FROM telefone WHERE id_pessoa = :id_pessoa';
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id_pessoa', $idPessoa);
            $stmt->execute();

            // exclui a pessoa
            $query = 'DELETE FROM pessoa WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id', $idPessoa);
            $stmt->execute();

            $this->conn->commit();

            return 'ok';
        } catch (PDOException $e) {
            $this->conn->rollback();

            return 'Erro ao excluir pessoa: ' . $e->getMessage();
        }
    }
}
