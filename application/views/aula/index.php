<div class="row area-row-cadastro">
    <div class="col col-10">
        <span class="titulo-row-cadastro">AULAS</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <a style="font-weight: 700;" href="<?= base_url('Aulas/cadastro') ?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
    </div>
</div>

<div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
</div>

<div>
    <table class="table table-striped tabela-aulas">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;" scope="col">#</th>
                <th style="text-align: center;" scope="col">Modalidade</th>
                <th style="text-align: center;" scope="col">Professor</th>
                <th style="text-align: center;" scope="col">Horário</th>
                <th style="text-align: center;" scope="col">Capacidade (pessoas)</th>
                <th style="text-align: center;" scope="col" width="150">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aulas as $aula) : ?>
                <tr data-id="<?= $aula->getId() ?>" class="tr-aula-<?= $aula->getId() ?>">
                    <td style="text-align: center;" scope="row"><?= $aula->getId() ?></td>
                    <td style="text-align: center;"><?= $aula->getModalidade()->getNome() ?></td>
                    <td style="text-align: center;"><?= $aula->getProfessor()->getNome() ?></td>
                    <td style="text-align: center;"><?= $aula->getHorario()->format('H:i') ?></td>
                    <td style="text-align: center;"><?= $aula->getCapacidade() ?></td>
                    <td>
                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                            <a href="<?= base_url('Aulas/editar/') . $aula->getId() ?>" class="btn btn-warning link-acoes">EDITAR</a>
                            <a class="btn btn-danger link-acoes excluir-aula">EXCLUIR</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6"><?= $this->pagination->create_links(); ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<div style="margin-top: 15%" class="modal" id="modal-excluir-aula" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="idHidden" value="">
            <div class="modal-header">
                <h5 class="modal-title">EXCLUIR AULA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir essa aula?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">NÃO</button>
                <button type="button" class="btn btn-danger confirmar-excluir">SIM</button>
            </div>
        </div>
    </div>
</div>

<script>
    function onReady() {

        $('.nav-link').removeClass('active');
        $('.aulas-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });


        $('.excluir-aula').click(function() {
            var id = $(this).closest('tr').data('id');
            $('input[name=idHidden]').val(id);
            $('#modal-excluir-aula').modal();
        });

        $('.confirmar-excluir').click(function() {
            var id = $('input[name=idHidden]').val();

            $.post('<?= base_url('Aulas/excluir') ?>/' + id, function(retorno) {
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

                    $(`.tr-aula-${id}`).remove();
                }
            }, "json");

            $('#modal-excluir-aula').modal('hide');
        });
    }
</script>