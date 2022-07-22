<div class="row area-row-cadastro">
    <div class="col col-10">
        <span class="titulo-row-cadastro">EXERCÍCIOS</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <a style="font-weight: 700;" href="<?= base_url('Exercicios/cadastro') ?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
    </div>
</div>

<div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
</div>

<div>
    <table class="table table-striped tabela-exercicios">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;" scope="col">#</th>
                <th style="text-align: center;" scope="col">Nome</th>
                <th style="text-align: center;" scope="col">Categoria</th>
                <!-- <th style="text-align: center;" scope="col">Modalidade</th> -->
                <th style="text-align: center;" scope="col">Medida</th>
                <th style="text-align: center;" scope="col" width="150">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exercicios as $exercicio) : ?>
                <tr data-id="<?= $exercicio->getId() ?>" class="tr-exercicio-<?= $exercicio->getId() ?>">
                    <td style="text-align: center;" scope="row"><?= $exercicio->getId() ?></td>
                    <td style="text-align: center;" scope="row"><?= $exercicio->getNome() ?></td>
                    <td style="text-align: center;"><?= $exercicio->getCategoria()->getNome() ?></td>
                    <td style="text-align: center;"><?= $exercicio->getMedida()->getNome()  ?></td>
                    <td>
                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                            <a href="<?= base_url('Exercicios/editar/') . $exercicio->getId() ?>" class="btn btn-warning link-acoes">EDITAR</a>
                            <a class="btn btn-danger link-acoes excluir-exercicio">EXCLUIR</a>
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

<div style="margin-top: 15%" class="modal" id="modal-excluir-exercicio" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="idHidden" value="">
            <div class="modal-header">
                <h5 class="modal-title">EXCLUIR EXERCÍCIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja excluir essa exercício?</p>
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
        $('.exercicio-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });


        $('.excluir-exercicio').click(function() {
            var id = $(this).closest('tr').data('id');
            $('input[name=idHidden]').val(id);
            $('#modal-excluir-exercicio').modal();
        });

        $('.confirmar-excluir').click(function() {
            var id = $('input[name=idHidden]').val();

            $.post('<?= base_url('Exercicios/excluir') ?>/' + id, function(retorno) {
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

                    $(`.tr-exercicio-${id}`).remove();
                }
            }, "json");

            $('#modal-excluir-exercicio').modal('hide');
        });
    }
</script>