<?php
require_once 'config.php';
class Telefone
{


    private $id;
    private $pessoaId;
    private $telefone;
    private $descricao;

    public function __construct($pessoaId, $telefone, $descricao)
    {
        $this->pessoaId = $pessoaId;
        $this->telefone = $telefone;
        $this->descricao = $descricao;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPessoaId()
    {
        return $this->pessoaId;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPessoaId($pessoaId)
    {
        $this->pessoaId = $pessoaId;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function salvar()
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare('INSERT INTO telefones (pessoa_id, telefone, descricao) VALUES (:pessoa_id, :telefone, :descricao)');
            $stmt->execute(array(
                ':pessoa_id' => $this->getPessoaId(),
                ':telefone' => $this->getTelefone(),
                ':descricao' => $this->getDescricao()
            ));

            $this->setId($pdo->lastInsertId());

            return true;
        } catch (PDOException $e) {
            echo "Erro ao salvar telefone: " . $e->getMessage();
        }
    }

    public static function buscarPorPessoaId($pessoaId)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare('SELECT * FROM telefones WHERE pessoa_id = :pessoa_id');
            $stmt->execute(array(':pessoa_id' => $pessoaId));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $telefones = array();

            foreach ($result as $row) {
                $telefone = new Telefone($row['pessoa_id'],
                    $row['telefone'],
                    $row['descricao']
                );
                $telefone->setId($row['id']);

                array_push($telefones, $telefone);
            }

            return $telefones;
        } catch (PDOException $e) {
            echo "Erro ao buscar telefones: " . $e->getMessage();
        }
    }
    public function atualizar() {
        global $pdo;

        try {
            $stmt = $pdo->prepare('UPDATE telefones SET pessoa_id = :pessoa_id, telefone = :telefone, descricao = :descricao WHERE id = :id');
            $stmt->execute(array(
                ':pessoa_id' => $this->getPessoaId(),
                ':telefone' => $this->getTelefone(),
                ':descricao' => $this->getDescricao(),
                ':id' => $this->getId()
            ));

            return true;
        } catch (PDOException $e) {
            echo "Erro ao atualizar telefone: " . $e->getMessage();
        }
    }
    public function deletar() {
        global $pdo;

        try {
            $stmt = $pdo->prepare('DELETE FROM telefones WHERE id = :id');
            $stmt->execute(array(':id' => $this->getId()));

            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar telefone: " . $e->getMessage();
        }
    }

}