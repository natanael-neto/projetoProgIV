<div class="container">
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro">TREINO</span>
        </div>
    </div>
    <br><br><br>
    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert">
    </div>

    <?php if (isset($_GET['select']) && $_GET['select'] == 'erro1') : ?>
        <div style="background-color:#ffff9e; color:#3f3f3f;" class="alert alert-dismissible fade show retorno-erro" role="alert">
            <p><strong>Por favor, selecione uma modalidade.</strong></p>
        </div>
    <?php endif; ?>
        
    <?php if (isset($_GET['select']) && $_GET['select'] == 'erro2') : ?>
        <div style="background-color:#ffff9e; color:#3f3f3f;" class="alert alert-dismissible fade show retorno-erro" role="alert">
            <p><strong>Por favor, selecione uma dificuldade.</strong></p>
        </div>
    <?php endif; ?>
    <hr>

    <form id="form-treinos" method="post" action="<?= base_url('Treinos/gerar') ?>" autocomplete="off">
    
        <div class="row row-form">
            <div class="col col-12 title-form">
                DADOS:
            </div>
        </div>

        <div class="row row-form">

            <div class="col col-lg-4 col-xs-12">
                <label for="select-modalidade">MODALIDADE</label>
                <select name="modalidade" class="form-control" id="select-modalidade">
                    <option>...</option>
                    <?php foreach ($modalidades as $modalidade) : ?>
                        <option value="<?= $modalidade->getId() ?>"><?= $modalidade->getNome() ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            
            <div class="col col-lg-6 col-xs-12">
                <label for="select-dificuldade">DIFICULDADE</label>
                <select name="dificuldade" class="form-control" id="select-dificuldade">
                    <option>...</option>
                    <option>Facíl</option>
                    <option>Médio</option>
                    <option>Difícil</option>
                </select>
            </div>
        </div>

        <div style="text-align: end;" class="row row-form">
            <div class="col col-12">
                <button type="submit" id="botao-salvar" class="btn btn-success btn-md">
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
        $('.treinos-link').addClass('active');
        //$('#treinos').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });

    }
</script>
