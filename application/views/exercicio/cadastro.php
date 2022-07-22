<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= isset($exercicio) ? "EDITAR" : "CADASTRAR " ?> EXERCICIO</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-exercicios" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($exercicio) ? $exercicio->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="input-nome">NOME</label>
                <input value="<?= isset($exercicio) ? $exercicio->getNome() : "" ?>" type="text" class="form-control" id="input-nome" name="nome">
            </div>
        </div>

        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="select-medida">MEDIDA</label>
                <select name="medida" class="form-control" id="select-medida">
                    <?php foreach ($medidas as $medida) : ?>
                        <option <?= isset($exercicio) && $exercicio->getMedida()->getId() == $medida->getId() ? 'selected' : "" ?> value="<?= $medida->getId() ?>"><?= $medida->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col col-lg-6 col-xs-12">
                <label for="select-categoria">CATEGORIA</label>
                <select name="categoria" class="form-control" id="select-categoria">
                    <?php foreach ($categorias as $categoria) : ?>
                        <option <?= isset($exercicio) && $exercicio->getCategoria()->getId() == $categoria->getId() ? 'selected' : "" ?> value="<?= $categoria->getId()?>"><?= $categoria->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="select-modalidades">MODALIDADES (Para selecionar várias, pressione 'CTRL' e clique nas desejadas)</label>
                <select multiple class="form-control" id="select-modalidades" name="modalidades[]">
                    <?php
                    if (isset($exercicio)) {
                        $modalidadesExercicio = [];

                        foreach ($exercicio->getModalidades() as $modalidade) {
                            $modalidadesExercicio[] = $modalidade->getId();
                        }
                    }
                    ?>
                    <?php foreach ($modalidades as $modalidade) : ?>
                        <option <?= isset($exercicio) && in_array($modalidade->getId(), $modalidadesExercicio) ? 'selected ' : "" ?> value="<?= $modalidade->getId() ?>"><?= $modalidade->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
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
        $('.exercicios-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-exercicios').serialize();

            console.log(form)

            $.post('<?= base_url('Exercicios/cadastroAction') ?>', form, function(retorno) {
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
                    $('#form-exercicios input').val("");
                    $('#form-exercicios textarea').val("");
                    $("#form-exercicios select").val([]);
                }
            }, "json");
        });

    }
</script>