<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro">CADASTRAR PROFESSOR</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-professores" autocomplete="off">
    <input type="hidden" name="id" value="<?= isset($professor) ? $professor->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-nome">NOME</label>
                <input value="<?= isset($professor) ? $professor->getNome() : "" ?>" type="text" class="form-control" id="input-nome" name="nome">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cpf">CPF</label>
                <input value="<?= isset($professor) ? $professor->getCpf() : "" ?>" type="text" class="form-control" id="input-cpf" name="cpf">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-email">E-MAIL</label>
                <input value="<?= isset($professor) ? $professor->getEmail() : "" ?>" type="email" class="form-control" id="input-email" aria-describedby="emailHelp" name="email">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="input-telefone">TELEFONE</label>
                <input value="<?= isset($professor) ? $professor->getTelefone() : "" ?>" type="text" class="form-control" id="input-telefone" name="telefone">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-data-nascimento">DATA DE NASCIMENTO</label>
                <input value="<?= isset($professor) ? $professor->getDataNascimento()->format('d/m/Y') : "" ?>"  type="text" class="form-control" id="input-data-nascimento" name="dataNascimento">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cref">CREF</label>
                <input value="<?= isset($professor) ? $professor->getCref() : "" ?>" type="text" class="form-control" id="input-cref" name="cref">
            </div>
        </div>
        <hr>
        <div class="row row-form">
            <div class="col col-12 title-form">
                ENDEREÇO:
            </div>
            <div class="col col-lg-10 col-xs-12">
                <label for="input-logradouro">LOGRADOURO</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getLogradouro() : "" ?>" type="text" class="form-control" id="input-logradouro" name="logradouro">
            </div>
            <div class="col col-lg-2 col-xs-12">
                <label for="input-numero">NÚMERO</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getNumero() : "" ?>" type="text" class="form-control" id="input-numero" name="numero">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cidade">CIDADE</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getCidade() : "" ?>" type="text" class="form-control" id="input-cidade" name="cidade">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-estado">ESTADO</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getEstado() : "" ?>" type="text" class="form-control" id="input-estado" name="estado">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-pais">PAÍS</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getPais() : "" ?>" type="text" class="form-control" id="input-pais" name="pais">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="input-bairro">BAIRRO</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getBairro() : "" ?>" type="text" class="form-control" id="input-bairro" name="bairro">
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="input-complemento">COMPLEMENTO</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getComplemento() : "" ?>" type="text" class="form-control" id="input-complemento" name="complemento">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-9 col-xs-9">
                <label for="input-pontoReferencia">PONTO DE REFERÊNCIA</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getPontoReferencia() : "" ?>" type="text" class="form-control" id="input-pontoReferencia" name="pontoReferencia">
            </div>
            <div class="col col-lg-3 col-xs-3">
                <label for="input-cep">CEP</label>
                <input value="<?= isset($professor) ? $professor->getEndereco()->getCep() : "" ?>" type="text" class="form-control" id="input-cep" name="cep">
            </div>
        </div>
        <div style="text-align: end;" class="row row-form">
            <div class="col col-12">
                <button type="button" id="botao-salvar" class="btn btn-success btn-md">
                    SALVAR
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function onReady() {
        // marcação no dropdown
        $('.nav-link').removeClass('active');
        $('.professores-link').addClass('active');
        $('#dropdown-cadastros').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // máscaras
        $('#input-cpf').mask("999.999.999-99");
        $('#input-telefone').mask("(99) 99999-9999");
        $('#input-data-nascimento').mask("99/99/9999");
        $('#input-cep').mask("99.999-999");

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-professores').serialize();

            $.post('<?= base_url('Professores/cadastroAction') ?>', form, function(retorno) {
                if (retorno.erro) {
                    $('.retorno-erro').html("");
                    $('.retorno-erro').addClass('alert-warning');
                    $('.retorno-erro').html(`<strong>Atenção!</strong> ${retorno.mensagem}\
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>\
                                                <span aria-hidden='true'>&times;</span>\
                                            </button>`);
                    $('.retorno-erro').show();
                } else {
                    $('.retorno-erro').html("");
                    if ($('.retorno-erro').hasClass('alert-warning')) {
                        $('.retorno-erro').removeClass('alert-warning');
                    }
                    $('.retorno-erro').addClass('alert-success');
                    $('.retorno-erro').html(`${retorno.mensagem}\
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>\
                                                <span aria-hidden='true'>&times;</span>\
                                            </button>`);
                    $('.retorno-erro').show();
                    $('#form-professores input').val("");
                }
            }, "json");
        });
    }
</script>