<?php

require_once '../model/Pessoa.php';
require_once '../model/Telefone.php';
require_once '../model/PessoaController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];

    switch ($acao) {
        case 'cadastrarPessoa':
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            $descricaoTelefone = $_POST['descricaoTelefone'];

            $pessoaController = new PessoaController();
            $result = $pessoaController->cadastrarPessoa($nome, $cpf, $endereco, $telefone, $descricaoTelefone);

            echo $result;
            break;

        case 'listarPessoas':
            $pessoaController = new PessoaController();
            $result = $pessoaController->listarPessoas();

            echo json_encode($result);
            break;

        case 'excluirPessoa':
            $idPessoa = $_POST['idPessoa'];

            $pessoaController = new PessoaController();
            $result = $pessoaController->excluirPessoa($idPessoa);

            echo $result;
            break;

        default:
            echo 'Ação inválida';
            break;
    }
} else {
    echo 'Requisição inválida';
}
