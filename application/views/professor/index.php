<div class="row area-row-cadastro">
    <div class="col col-10">
        <span class="titulo-row-cadastro">PROFESSORES</span>
    </div>
    <div class="col col-2 col-botao-cadastro">
        <a style="font-weight: 700;" href="<?= base_url('Professores/cadastro')?>" class="btn btn-md btn-info"><i class="fa fa-plus icon-botao-sair"></i> CADASTRAR</a>
    </div>
</div>

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
            <tr>
                <td style="text-align: center;">#</td>
                <td style="text-align: center;">Nome</td>
                <td style="text-align: center;">E-mail</td>
                <td style="text-align: center;">CREF</td>
                <td style="text-align: center;">
                    <a class="btn btn-sm btn-warning">Editar</a>
                    <a class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">#</td>
                <td style="text-align: center;">Nome</td>
                <td style="text-align: center;">E-mail</td>
                <td style="text-align: center;">CREF</td>
                <td style="text-align: center;">
                    <a class="btn btn-sm btn-warning">Editar</a>
                    <a class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">#</td>
                <td style="text-align: center;">Nome</td>
                <td style="text-align: center;">E-mail</td>
                <td style="text-align: center;">CREF</td>
                <td style="text-align: center;">
                    <a class="btn btn-sm btn-warning">Editar</a>
                    <a class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
            <?php foreach ($professores as $professor) : ?>
                <tr>
                    <td scope="row"><?= $professor->getId() ?></td>
                    <td><?= $professor->getNome() ?></td>
                    <td><?= $professor->getEmail() ?></td>
                    <td><?= $professor->getCref() ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
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