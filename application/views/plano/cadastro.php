<div style="margin-bottom: 100px" class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro">CADASTRAR PLANO</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-planos" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($plano) ? $plano->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-6">
                <label for="input-nome">NOME</label>
                <input value="<?= isset($plano) ? $plano->getNome() : "" ?>" type="text" class="form-control" id="input-nome" name="nome">
            </div>
            <div class="col col-lg-6 col-xs-6">
                <label for="input-valor">VALOR</label>
                <input type="text" name="valor" class="form-control" id="input-valor" value="<?= isset($plano) ? formatar_dinheiro($plano->getValor()) : "" ?>">
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="select-modalidades">MODALIDADES (Para selecionar várias, pressione 'CTRL' e clique nas desejadas)</label>
                <select multiple class="form-control" id="select-modalidades" name="modalidades[]">
                    <?php
                    if (isset($plano)) {
                        $modalidadesPlano = [];

                        foreach ($plano->getModalidades() as $modalidade) {
                            $modalidadesPlano[] = $modalidade->getId();
                        }
                    }
                    ?>
                    <?php foreach ($modalidades as $modalidade) : ?>
                        <option <?= isset($plano) && in_array($modalidade->getId(), $modalidadesPlano) ? 'selected ' : "" ?> value="<?= $modalidade->getId() ?>"><?= $modalidade->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="input-descricao">DESCRIÇÃO</label>
                <textarea name="descricao" class="form-control" id="input-descricao" rows="3"><?= isset($plano) ? $plano->getDescricao() : "" ?></textarea>
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
        $('.planos-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-planos').serialize();

            console.log(form)

            $.post('<?= base_url('Planos/cadastroAction') ?>', form, function(retorno) {
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
                    $('#form-planos input').val("");
                    $('#form-planos textarea').val("");
                    $("#form-planos select").val([]);
                }
            }, "json");
        });

        $("#input-valor").maskMoney({
            prefix: "R$ ",
            decimal: ",",
            thousands: "."
        });
    }
</script>