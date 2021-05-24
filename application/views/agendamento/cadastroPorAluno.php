<div class="container">
    <div class="row">
        <div class="col-12 mensagem-inicio">
            <h1>Olá, <strong><?= $aluno->getNome() ?></strong>!</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 mensagem-inicio">
            <h4>AGENDE SUAS AULAS!</h4>
        </div>
    </div>
    <div style="display:none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>
    <form autocomplete="off" id="form-agendamentos-alunos">
        <input type="hidden" name="aluno" value="<?= $this->usuarioLogado->getAluno()->getId() ?>">
        <input type="hidden" name="cadastroPorAluno" value="1">
        <div class="row">
            <div class="col col-lg-6 col-xs-12">
                <label for="select-dia">DIA</label>
                <select name="data" class="form-control" id="select-dia">
                    <option value="hoje">Hoje</option>
                    <option value="amanha">Amanhã</option>
                </select>
            </div>
            <div class="col col-lg-6 col-xs-12">
                <label for="select-aula">AULA</label>
                <select name="aula" class="form-control" id="select-aula">
                    <?php foreach ($aulas as $aula) : ?>
                        <option value="<?= $aula->getId() ?>"><?= $aula->getModalidade()->getNome() . " (" . $aula->getHorario()->format('H:i') . ") " ?></option>
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
        $('.agendamento-aluno-link').addClass('active');
        $('#dropdown-ag-alunos').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
        // submit do form
        $('#botao-salvar').click(function() {
            var form = $('#form-agendamentos-alunos').serialize();

            console.log(form)

            $.post('<?= base_url('Agendamentos/cadastroAction') ?>', form, function(retorno) {
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
                    $('#form-agendamentos-alunos input').val("");
                    $("#form-agendamentos-alunos select").val([]);
                }
            }, "json");
        });
    }
</script>