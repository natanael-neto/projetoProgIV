<div class="row area-row-cadastro">
    <div class="col col-10">
        <span class="titulo-row-cadastro">PROFESSORES</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <a style="font-weight: 700;" href="<?= base_url('Professores/cadastro') ?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
    </div>
</div>

<?php if (!empty($this->session->flashdata('message'))) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('message') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div>
    <table class="table table-striped tabela-professores">
        <thead class="thead-dark">
            <tr>
                <th style="text-align: center;" scope="col">#</th>
                <th style="text-align: center;" scope="col">Nome</th>
                <th style="text-align: center;" scope="col">E-mail</th>
                <th style="text-align: center;" scope="col">CREF</th>
                <th style="text-align: center;" scope="col" width="150">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($professores as $professor) : ?>
                <tr>
                    <td style="text-align: center;" scope="row"><?= $professor->getId() ?></td>
                    <td style="text-align: center;"><?= $professor->getNome() ?></td>
                    <td style="text-align: center;"><?= $professor->getEmail() ?></td>
                    <td style="text-align: center;"><?= $professor->getCref() ?></td>
                    <td>
                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group">
                            <a class="btn btn-warning link-acoes">EDITAR</a>
                            <a class="btn btn-danger link-acoes">EXCLUIR</a>
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


<script>
    function onReady() {

        $('.nav-link').removeClass('active');
        $('.professores-link').addClass('active');
        $('#dropdown-cadastros').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    }
</script>