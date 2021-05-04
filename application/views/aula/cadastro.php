<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= isset($aula) ? "EDITAR" : "CADASTRAR" ?> AULA</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-aulas" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($aula) ? $aula->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="select-modalidade">MODALIDADE</label>
                <select name="modalidade" class="form-control" id="select-modalidade">
                    <?php foreach ($modalidades as $modalidade) : ?>
                        <option <?= isset($aula) && $aula->getModalidade()->getId() == $modalidade->getId() ? 'selected' : "" ?> value="<?= $modalidade->getId() ?>"><?= $modalidade->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="select-professor">PROFESSOR</label>
                <select name="professor" class="form-control" id="select-professor">
                    <?php foreach ($professores as $professor) : ?>
                        <option <?= isset($aula) && $aula->getProfessor()->getId() == $professor->getId() ? 'selected' : "" ?> value="<?= $professor->getId() ?>"><?= $professor->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="input-horario">HORÁRIO</label>
                <input type="text" name="horario" class="form-control" id="input-horario" rows="3" value="<?= isset($aula) ? $aula->getHorario()->format('H:i') : "" ?>">
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="input-capacidade">CAPACIDADE</label>
                <input type="text" name="capacidade" class="form-control" id="input-capacidade" rows="3" value="<?= isset($aula) ? $aula->getCapacidade() : "" ?>">
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
        $('.aulas-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // máscaras
        $('#input-horario').mask("99:99");

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-aulas').serialize();

            $.post('<?= base_url('Aulas/cadastroAction') ?>', form, function(retorno) {
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
                    $('#form-aulas input').val("");
                    $$("#form-aulas select").val([]);
                }
            }, "json");
        });
    }
</script>