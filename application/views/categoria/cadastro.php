<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= isset($categoria) ? "EDITAR" : "CADASTRAR" ?> CATEGORIA</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-categoria" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($categoria) ? $categoria->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="input-nome">NOME</label>
                <input value="<?= isset($categoria) ? $categoria->getNome() : "" ?>" type="text" class="form-control" id="input-nome" name="nome">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="input-descricao">DESCRIÇÃO</label>
                <textarea name="descricao" class="form-control" id="input-descricao" rows="3"><?= isset($categoria) ? $categoria->getDescricao() : "" ?></textarea>
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
        $('.categoria-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-categoria').serialize();

            
            $.post('<?= base_url('Categorias/cadastroAction') ?>', form, function(retorno) {
                console.log(retorno);
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
                    $('#form-categoria input').val("");
                }
            }, "json");
        });

    }
</script>