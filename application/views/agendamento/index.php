<div class="row <?= $this->usuarioLogado->getPerfil()->getNome() != 'aluno' ? 'area-row-cadastro' : 'area-row-cadastro-aluno' ?>">
    <div class="col col-10">
        <span class="titulo-row-cadastro">AGENDAMENTOS</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <?php if ($this->usuarioLogado->getPerfil()->getNome() != 'aluno') : ?>
            <a style="font-weight: 700;" href="<?= base_url('Agendamentos/cadastro') ?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
        <?php endif; ?>
    </div>
</div>

<div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
</div>

<div>
    <table class="table table-striped tabela-agendamentos">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;" scope="col">#</th>
                <th style="text-align: center;" scope="col">Aluno</th>
                <th style="text-align: center;" scope="col">Data</th>
                <th style="text-align: center;" scope="col">Horário da Aula</th>
                <th style="text-align: center;" scope="col">Modalidade</th>
                <th style="text-align: center;" scope="col">Professor</th>
                <th style="text-align: center;" scope="col" width="150">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento) : ?>
                <tr data-id="<?= $agendamento->getId() ?>" class="tr-agendamento-<?= $agendamento->getId() ?>">
                    <td style="text-align: center;" scope="row"><?= $agendamento->getId() ?></td>
                    <td style="text-align: center;"><?= $agendamento->getAluno()->getNome() ?></td>
                    <td style="text-align: center;"><?= $agendamento->getDataAgendamento()->format('d/m/Y') ?></td>
                    <td style="text-align: center;"><?= $agendamento->getAula()->getHorario()->format('H:i') ?></td>
                    <td style="text-align: center;"><?= $agendamento->getAula()->getModalidade()->getNome() ?></td>
                    <td style="text-align: center;"><?= $agendamento->getAula()->getProfessor()->getNome() ?></td>
                    <td>
                        <?php if ($this->usuarioLogado->getPerfil()->getNome() != 'aluno') : ?>
                            <?php if ($agendamento->getDataAgendamento() > new DateTime('today')) : ?>
                                <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                                    <a href="<?= base_url('Agendamentos/editar/') . $agendamento->getId() ?>" class="btn btn-warning link-acoes">EDITAR</a>
                                    <a class="btn btn-danger link-acoes excluir-agendamento">EXCLUIR</a>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($agendamento->getDataAgendamento() > new DateTime('today')) : ?>
                                <button type="button" class="btn btn-danger btn-sm link-acoes excluir-agendamento">EXCLUIR</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7"><?= $this->pagination->create_links(); ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<div style="margin-top: 15%" class="modal" id="modal-excluir-agendamento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="idHidden" value="">
            <div class="modal-header">
                <h5 class="modal-title">EXCLUIR AGENDAMENTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir essa agendamento?</p>
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
        $('.agendamentos-link').addClass('active');
        $('#dropdown-operacional').addClass('active');
        $('#dropdown-ag-alunos').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });


        $('.excluir-agendamento').click(function() {
            var id = $(this).closest('tr').data('id');
            $('input[name=idHidden]').val(id);
            $('#modal-excluir-agendamento').modal();
        });

        $('.confirmar-excluir').click(function() {
            var id = $('input[name=idHidden]').val();

            $.post('<?= base_url('Agendamentos/excluir') ?>/' + id, function(retorno) {
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

                    $(`.tr-agendamento-${id}`).remove();
                }
            }, "json");

            $('#modal-excluir-agendamento').modal('hide');
        });
    }
</script>