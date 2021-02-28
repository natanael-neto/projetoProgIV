<?php include APPPATH . 'views\layoutElements\navInicio.php' ?>

<div class="container">
    <div class="row">
        <div class="col-12 main-title">
            <p>Insira seus dados</p>
        </div>
    </div>

    <form>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <p>CPF </p>
                    <input type="text" id="cpf-login" class="form-control form-control-lg" placeholder="Digite seu CPF.">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <p>Senha </p>
                    <input type="password" class="form-control form-control-lg" placeholder="Digite sua senha.">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-lg botao-submit-login">ENTRAR</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function onReady() {
        $('#cpf-login').mask("999.999.999-99");
    }
</script>