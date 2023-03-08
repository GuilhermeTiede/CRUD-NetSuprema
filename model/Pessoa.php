<?php


require_once 'config.php';
class Pessoa
{


    private $id;
    private $nome;
    private $cpf;
    private $endereco;

    public function __construct($nome, $cpf, $endereco)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function salvar()
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare('INSERT INTO pessoas (nome, cpf, endereco) VALUES (:nome, :cpf, :endereco)');
            $stmt->execute(array(
                ':nome' => $this->getNome(),
                ':cpf' => $this->getCpf(),
                ':endereco' => $this->getEndereco()
            ));

            $this->setId($pdo->lastInsertId());

            return true;
        } catch (PDOException $e) {
            echo "Erro ao salvar pessoa: " . $e->getMessage();
        }
    }

    public static function buscarPorId($id)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare('SELECT * FROM pessoas WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $pessoa = new Pessoa($result['nome'], $result['cpf'], $result['endereco']);
                $pessoa->setId($result['id']);

                return $pessoa;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar pessoa: " . $e->getMessage();
        }
    }

    public static function buscarTodos()
    {
        global $pdo;

        try {
            $stmt = $pdo->query('SELECT * FROM pessoas');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pessoas = array();

            foreach ($result as $row) {
                $pessoa = new Pessoa($row['nome'], $row['cpf'], $row['endereco']);
                $pessoa->setId($row['id']);

                $pessoas[] = $pessoa;
                }
            return $pessoas;
        }catch (PDOException $e) {
            echo "Erro ao buscar pessoas: " . $e->getMessage();
        }

        }
    public function atualizar() {
        global $pdo;

        try {
            $stmt = $pdo->prepare('UPDATE pessoas SET nome = :nome, cpf = :cpf, endereco = :endereco WHERE id = :id');
            $stmt->execute(array(
                ':nome' => $this->getNome(),
                ':cpf' => $this->getCpf(),
                ':endereco' => $this->getEndereco(),
                ':id' => $this->getId()
            ));

            return true;
        } catch (PDOException $e) {
            echo "Erro ao atualizar pessoa: " . $e->getMessage();
        }
    }
    public function deletar() {
        global $pdo;

        try {
            $stmt = $pdo->prepare('DELETE FROM pessoas WHERE id = :id');
            $stmt->execute(array(':id' => $this->getId()));

            return true;
        } catch (PDOException $e) {
            echo "Erro ao deletar pessoa: " . $e->getMessage();
        }
    }
}