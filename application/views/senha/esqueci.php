<div class="container">
    <br>
    <div class="row" style="margin-top: 13%;">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= $titulo ?></span>
        </div>
    </div>

    <div style="display: none;" class="alert alert-dismissible fade show retorno-erro" role="alert"></div>

    <hr>
    <form id="form-forget" autocomplete="off" style = "padding-top: 10px;">
        
            <div class="row row-form" >
                <div class="col col-lg-11 col-xs-12" style= "margin: auto;">
                    <p style="text-align: center; color: #808080;"> Informe seu cpf e enviaremos instruções por e-mail para você criar sua senha.</p>
                </div>
            </div>

            <div class="row row-form" >
                <div class="col col-lg-11 col-xs-12" style= "margin: auto;">
                    <label>CPF</label>
                    <input type="text" class="form-control " id="input-cpf" placeholder = "Digite seu cpf" name="input-cpf" required>
                </div>
            </div>

            <br>
            <div style="text-align: center; " class="row row-form">
                <div class="col col-12">
                    <button type="button" id="botao-salvar" class="btn btn-success btn-lg btn-block">Enviar</button>
                </div>
            </div>
    </form>
</div>

<div style="margin-top: 15%" class="modal" id="recuperar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <input type="hidden" name="idHidden" value="">
            <div class="modal-header" style="text-align: center;">
                <h5 class="modal-title">E-mail enviado!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <p style="margin-bottom: -30px;">Enviamos um e-mail com instruções para a criação de uma nova senha para:</p>
            </div>
            <div class="modal-body" style="text-align: center; ">
                <hr>
                <span id="email"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success confirmar-excluir">OK!</button>
            </div>
        </div>
    </div>
</div>

<script>

    function onReady(){

        $("#input-cpf").mask('999.999.999-99');


        $('#botao-salvar').click(function() {

            var form = $('#form-forget').serialize();

            $.post('<?= base_url('Login/esqueciBuscar') ?>', form, function(retorno) {
                if(retorno.erro){
                    $('.retorno-erro').html("");
                    $('.retorno-erro').addClass('alert-warning');
                    $('.retorno-erro').html(`<strong>Atenção!</strong> ${retorno.mensagem}`);
                    $('.retorno-erro').show();
                    $('#input-cpf').val("");

                } else {
                    $('.retorno-erro').html("");
                    if ($('.retorno-erro').hasClass('alert-warning')) {
                        $('.retorno-erro').removeClass('alert-warning');
                    }
                    $('#email').html(`<span><b>${retorno.email}</b></span>`);
                    $('#recuperar').modal();
                    $('#input-cpf').val("");
                }

            }, "json");
            
        });

        $('.confirmar-excluir').click(function() {
            $('#recuperar').modal('hide');
        });
    } 
</script>