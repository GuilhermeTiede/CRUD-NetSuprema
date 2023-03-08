<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoas</title>
    <!-- Importando CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Importando jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Importando JavaScript do Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Cadastro de Pessoas</h2>
    <br>
    <!-- Botão para abrir o modal de cadastro -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Nova Pessoa</button>
    <br><br>
    <!-- Tabela para exibir a lista de pessoas cadastradas -->
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>Telefones</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody id="table-body">
        <!-- Os dados serão carregados aqui via JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal de cadastro de pessoa -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Cabeçalho do modal -->
            <div class="modal-header">
                <h4 class="modal-title">Nova Pessoa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Formulário de cadastro -->
            <form id="form-cadastro" method="POST" action="controlador.php">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf">
                    </div>
                    <div class="form-group">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="form-control" id="endereco" name="endereco">
                    </div>
                    <!-- Lista dinâmica para adicionar telefones -->
                    <!-- Campos para adicionar telefones -->
                    <div id="telefones">
                        <div class="form-group telefone1">
                            <label for="telefone1">Telefone #1</label>
                            <input type="text" name="telefones[1][telefone]" id="telefone1" class="form-control telefone-input" required>
                        </div>
                        <div class="form-group telefone1">
                            <label for="descricao1">Descrição #1</label>
                            <input type="text" name="telefones[1][descricao]" id="descricao1" class="form-control descricao-input" required>
                        </div>
                    </div>
                    <div class="form-group" id="telefones-group">
                        <label for="telefones">Telefones:</label>
                        <ul id="telefones-list">
                            <!-- Os campos para os telefones serão adicionados aqui via JavaScript -->
                        </ul>
                        <button type="button" class="btn btn-primary" id="addTelefone">Adicionar Telefone</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Cadastrar">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
        </div>
    </div>
</div>
<!-- Scripts JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var i = 1;

        $('#addTelefone').click(function() {
            i++;

            var novoTelefone = $('<div>').attr('class', 'form-group telefone' + i);
            novoTelefone.append($('<label>').attr('for', 'telefone' + i).text('Telefone #' + i));
            novoTelefone.append($('<input>').attr({type: 'text', name: 'telefones[' + i + '][telefone]', id: 'telefone' + i, class: 'form-control telefone-input', required: true}));

            var novaDescricao = $('<div>').attr('class', 'form-group telefone' + i);
            novaDescricao.append($('<label>').attr('for', 'descricao' + i).text('Descrição #' + i));
            novaDescricao.append($('<input>').attr({type: 'text', name: 'telefones[' + i + '][descricao]', id: 'descricao' + i, class: 'form-control descricao-input', required: true}));

            $('#telefones').append(novoTelefone);
            $('#telefones').append(novaDescricao);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#telefone-table').DataTable({
            "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sem registros disponíveis",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                }s
            }
        });

        $("#cadastrar-telefone-form").submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: "TelefoneController.php",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Telefone cadastrado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ocorreu um erro ao cadastrar o telefone. Tente novamente mais tarde.'
                    });
                }
            });
        });

        $("#excluir-telefone-form").submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let formData = form.serialize();

            Swal.fire({
                title: 'Deseja realmente excluir esse telefone?',
                text: "Essa ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "model/TelefoneController.php",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Telefone excluído com sucesso!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            Swal.fire({icon: 'error',
                                title: 'Oops...',
                                text: 'Ocorreu um erro ao processar a requisição. Tente novamente mais tarde.'
                            });
                        }
                    });
                }
            });
        });
</script>
</body>
</html>
