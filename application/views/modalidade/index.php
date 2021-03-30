<div class="row area-row-cadastro">
    <div class="col col-10">
        <span class="titulo-row-cadastro">MODALIDADES</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <a style="font-weight: 700;" href="<?= base_url('Modalidades/cadastro') ?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
    </div>
</div>

<div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
</div>

<div>
    <table class="table table-striped tabela-modalidades">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;" scope="col">#</th>
                <th style="text-align: center;" scope="col">Nome</th>
                <th style="text-align: center;" scope="col" width="150">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modalidades as $modalidade) : ?>
                <tr data-id="<?= $modalidade->getId() ?>" class="tr-modalidade-<?= $modalidade->getId() ?>">
                    <td style="text-align: center;" scope="row"><?= $modalidade->getId() ?></td>
                    <td style="text-align: center;"><?= $modalidade->getNome() ?></td>
                    <td>
                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                            <a href="<?= base_url('Modalidades/editar/') . $modalidade->getId() ?>" class="btn btn-warning link-acoes">EDITAR</a>
                            <a class="btn btn-danger link-acoes excluir-modalidade">EXCLUIR</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5"><?= $this->pagination->create_links(); ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<div style="margin-top: 15%" class="modal" id="modal-excluir-modalidade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="idHidden" value="">
            <div class="modal-header">
                <h5 class="modal-title">EXCLUIR MODALIDADE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir essa modalidade?</p>
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
        $('.modalidades-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });


        $('.excluir-modalidade').click(function() {
            var id = $(this).closest('tr').data('id');
            $('input[name=idHidden]').val(id);
            $('#modal-excluir-modalidade').modal();
        });

        $('.confirmar-excluir').click(function() {
            var id = $('input[name=idHidden]').val();

            $.post('<?= base_url('Modalidades/excluir') ?>/' + id, function(retorno) {
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

                    $(`.tr-modalidade-${id}`).remove();
                }
            }, "json");

            $('#modal-excluir-modalidade').modal('hide');
        });
    }
</script>