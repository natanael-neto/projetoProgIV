<div class="container" >
    <div class="row">
        <div class="col-12 main-title" style="margin-top: 13%;">
            <p>Insira seus dados</p>
        </div>
    </div>

    <form action="<?= base_url('Login/logar') ?>" method="POST">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <p>CPF </p>
                    <input type="text" autocomplete="off" name="login" id="cpf-login" class="form-control form-control-lg" placeholder="Digite seu CPF.">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <p>Senha </p>
                    <input type="password" autocomplete="off" name="senha" class="form-control form-control-lg" placeholder="Digite sua senha.">
                </div>
                <a href="<?= base_url('Login/esqueci') ?>">Esqueceu sua senha?</a>
            </div>
            
            <div class="col-12">
                <div class="form-group">
                    
                    <button type="submit" class="btn btn-lg botao-submit-login">ENTRAR</button>
                </div>
            </div>
            <?php if (!empty($this->session->flashdata('message'))) : ?>
                <div class="col-12">
                    <div class="alert alert-danger" role="alert">
                        <?= $this->session->flashdata('message') ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    

<script>
    function onReady() {
        $('#cpf-login').mask("999.999.999-99");
    }
</script>