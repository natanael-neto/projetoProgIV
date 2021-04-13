<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= isset($agendamento) ? "EDITAR" : "CADASTRAR" ?> AGENDAMENTO</span>
        </div>
    </div>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <hr>
    <form id="form-agendamentos" autocomplete="off">
        <input type="hidden" name="id" value="<?= isset($agendamento) ? $agendamento->getId() : "" ?>">
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="select-aluno">ALUNO</label>
                <select name="aluno" class="form-control" id="select-aluno">
                    <?php foreach ($alunos as $aluno) : ?>
                        <option <?= isset($agendamento) && $agendamento->getAluno()->getId() == $aluno->getId() ? 'selected' : "" ?> value="<?= $aluno->getId() ?>"><?= $aluno->getNome() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-6 col-xs-12">
                <label for="select-data">DATA</label>
                <select name="data" class="form-control" id="select-data">
                    <option value="hoje">HOJE</option>
                    <option value="amanha">AMANHÃ</option>
                </select>
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="select-aula">AULA</label>
                <select name="aula" class="form-control" id="select-aula">
                    <?php foreach ($aulas as $aula) : ?>
                        <option <?= isset($agendamento) && $agendamento->getAula()->getId() == $aula->getId() ? 'selected' : "" ?> value="<?= $aula->getId() ?>"><?= $aula->getModalidade()->getNome() . " ({$aula->getProfessor()->getNome()})" . " - " . $aula->getHorario()->format('H:i') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row row-form">
            <div class="col col-lg-12 col-xs-12">
                <label for="input-observacao">OBSERVAÇÃO</label>
                <textarea name="observacao" class="form-control" id="input-observacao" rows="3"><?= isset($agendamento) && !is_null($agendamento->getObservacao()) ? $agendamento->getObservacao() : "" ?></textarea>
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
        $('.agendamentos-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // máscaras
        $('#input-horario').mask("99:99");

        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-agendamentos').serialize();

            $.post('<?= base_url('Agendamentos/cadastroAction') ?>', form, function(retorno) {
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
                    $('#form-agendamentos input').val("");
                    $$("#form-agendamentos select").val([]);
                }
            }, "json");
        });
    }
</script>