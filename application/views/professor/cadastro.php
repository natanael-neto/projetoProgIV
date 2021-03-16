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
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-nome">NOME</label>
                <input type="text" class="form-control" id="input-nome" name="nome">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cpf">CPF</label>
                <input type="text" class="form-control" id="input-cpf" name="cpf">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-email">E-MAIL</label>
                <input type="email" class="form-control" id="input-email" aria-describedby="emailHelp" name="email">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="input-telefone">TELEFONE</label>
                <input type="text" class="form-control" id="input-telefone" name="telefone">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-data-nascimento">DATA DE NASCIMENTO</label>
                <input type="text" class="form-control" id="input-data-nascimento" name="dataNascimento">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cref">CREF</label>
                <input type="text" class="form-control" id="input-cref" name="cref">
            </div>
        </div>
        <hr>
        <div class="row row-form">
            <div class="col col-12 title-form">
                ENDEREÇO:
            </div>
            <div class="col col-lg-10 col-xs-12">
                <label for="input-logradouro">LOGRADOURO</label>
                <input type="text" class="form-control" id="input-logradouro" name="logradouro">
            </div>
            <div class="col col-lg-2 col-xs-12">
                <label for="input-numero">NÚMERO</label>
                <input type="text" class="form-control" id="input-numero" name="numero">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cidade">CIDADE</label>
                <input type="text" class="form-control" id="input-cidade" name="cidade">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-estado">ESTADO</label>
                <input type="text" class="form-control" id="input-estado" name="estado">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-pais">PAÍS</label>
                <input type="text" class="form-control" id="input-pais" name="pais">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="input-bairro">BAIRRO</label>
                <input type="text" class="form-control" id="input-bairro" name="bairro">
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="input-complemento">COMPLEMENTO</label>
                <input type="text" class="form-control" id="input-complemento" name="complemento">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-9 col-xs-9">
                <label for="input-pontoReferencia">PONTO DE REFERÊNCIA</label>
                <input type="text" class="form-control" id="input-pontoReferencia" name="pontoReferencia">
            </div>
            <div class="col col-lg-3 col-xs-3">
                <label for="input-cep">CEP</label>
                <input type="text" class="form-control" id="input-cep" name="cep">
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

        $('.nav-link').removeClass('active');
        $('.professores-link').addClass('active');
        $('#dropdown-cadastros').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

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