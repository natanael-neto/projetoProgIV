<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= isset($funcionario) ? "EDITAR" : "CADASTRAR" ?> FUNCIONÁRIO</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-funcionarios" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($funcionario) ? $funcionario->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-nome">NOME</label>
                <input value="<?= isset($funcionario) ? $funcionario->getNome() : "" ?>" type="text" class="form-control" id="input-nome" name="nome">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cpf">CPF</label>
                <input value="<?= isset($funcionario) ? $funcionario->getCpf() : "" ?>" type="text" class="form-control" id="input-cpf" name="cpf">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-email">E-MAIL</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEmail() : "" ?>" type="email" class="form-control" id="input-email" aria-describedby="emailHelp" name="email">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="select-perfil">PERFIL DE ACESSO</label>
                <select name="perfil" class="form-control">
                    <?php foreach ($perfis as $perfil) : ?>
                        <?php 
                            if ($perfil->getNome() == 'aluno'){
                                continue;
                            }
                        ?>
                        <option <?= isset($funcionario) && $funcionario->getUsuario()->getPerfil()->getId() == $perfil->getId() ? 'checked' : '' ?> value="<?= $perfil->getId() ?>"><?= ucfirst($perfil->getNome()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-telefone">TELEFONE</label>
                <input value="<?= isset($funcionario) ? $funcionario->getTelefone() : "" ?>" type="text" class="form-control" id="input-telefone" name="telefone">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-data-nascimento">DATA DE NASCIMENTO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getDataNascimento()->format('d/m/Y') : "" ?>" type="text" class="form-control" id="input-data-nascimento" name="dataNascimento">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-3 col-xs-12">
                <label for="input-funcao">FUNÇÃO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getFuncao() : "" ?>" type="text" class="form-control" id="input-funcao" name="funcao">
            </div>
            <div class="col col-lg-3 col-xs-12">
                <label for="input-carga-horaria">CARGA HORÁRIA (h) </label>
                <input value="<?= isset($funcionario) ? $funcionario->getCargaHoraria() : "" ?>" type="text" class="form-control" id="input-carga-horaria" name="cargaHoraria">
            </div>
            <div class="col col-lg-3 col-xs-12">
                <label for="input-inicio-jornada">INÍCIO DA JORNADA</label>
                <input value="<?= isset($funcionario) ? $funcionario->getInicioJornada() : "" ?>" type="text" class="form-control" id="input-inicio-jornada" name="inicioJornada">
            </div>
            <div class="col col-lg-3 col-xs-12">
                <label for="input-saida-jornada">SAÍDA DA JORNADA</label>
                <input value="<?= isset($funcionario) ? $funcionario->getSaidaJornada() : "" ?>" type="text" class="form-control" id="input-saida-jornada" name="saidaJornada">
            </div>
        </div>
        <hr>
        <div class="row row-form">
            <div class="col col-12 title-form">
                ENDEREÇO:
            </div>
            <div class="col col-lg-10 col-xs-12">
                <label for="input-logradouro">LOGRADOURO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getLogradouro() : "" ?>" type="text" class="form-control" id="input-logradouro" name="logradouro">
            </div>
            <div class="col col-lg-2 col-xs-12">
                <label for="input-numero">NÚMERO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getNumero() : "" ?>" type="text" class="form-control" id="input-numero" name="numero">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-4 col-xs-12">
                <label for="input-cidade">CIDADE</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getCidade() : "" ?>" type="text" class="form-control" id="input-cidade" name="cidade">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-estado">ESTADO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getEstado() : "" ?>" type="text" class="form-control" id="input-estado" name="estado">
            </div>
            <div class="col col-lg-4 col-xs-12">
                <label for="input-pais">PAÍS</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getPais() : "" ?>" type="text" class="form-control" id="input-pais" name="pais">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="input-bairro">BAIRRO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getBairro() : "" ?>" type="text" class="form-control" id="input-bairro" name="bairro">
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="input-complemento">COMPLEMENTO</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getComplemento() : "" ?>" type="text" class="form-control" id="input-complemento" name="complemento">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-9 col-xs-9">
                <label for="input-pontoReferencia">PONTO DE REFERÊNCIA</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getPontoReferencia() : "" ?>" type="text" class="form-control" id="input-pontoReferencia" name="pontoReferencia">
            </div>
            <div class="col col-lg-3 col-xs-3">
                <label for="input-cep">CEP</label>
                <input value="<?= isset($funcionario) ? $funcionario->getEndereco()->getCep() : "" ?>" type="text" class="form-control" id="input-cep" name="cep">
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
        $('.funcionarios-link').addClass('active');
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
        $('#input-inicio-jornada').mask("99:99");
        $('#input-saida-jornada').mask("99:99");


        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-funcionarios').serialize();

            $.post('<?= base_url('Funcionarios/cadastroAction') ?>', form, function(retorno) {
                if (retorno.erro) {
                    $('.retorno-erro').html("");
                    $('.retorno-erro').addClass('alert-warning');
                    $('.retorno-erro').html(`<strong>Atenção!</strong> ${retorno.mensagem}`);
                    $('.retorno-erro').show();
                } else {
                    $('.retorno-erro').html("");
                    if ($('.retorno-erro').hasClass('alert-warning')) {
                        $('.retorno-erro').removeClass('alert-warning');
                    }
                    $('.retorno-erro').addClass('alert-success');
                    $('.retorno-erro').html(`${retorno.mensagem}`);
                    $('.retorno-erro').show();
                    $('#form-funcionarios input').val("");
                }
            }, "json");
        });
    }
</script>