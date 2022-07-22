<div class="container">
    <br>
    <div class="row">
        <div class="col col-12 col-titulo-page-cadastro">
            <span class="titulo-page-cadastro"><?= $titulo ?></span>
        </div>
    </div>

    <div style="display: none" class="alert alert-dismissible fade show retorno-erro" role="alert"></div>

    <hr>
    <form id="form-senha" autocomplete="off" style = "padding-top: 10px;">

            <div class="row row-form" >
                <div class="col col-lg-11 col-xs-12" style= "margin: auto;">
                    <input value="" type="password" class="antiga-senha form-control " id="input-antiga" placeholder = "Digite a senha atual" required name="input-antiga">
                </div>
            </div>
            <div class="row row-form" >
                <div class="col col-lg-11 col-xs-12" style= "margin: auto;">
                    <input  type="password" class="form-control password" id="input-senha" placeholder = "Digite a nova senha" required name="input-senha">
                </div>
            </div>

            <div class="container" style='margin-top: 15px; margin-botton: 9px;'>
                <span id="password-status"></span>
            </div>

            <div class="row row-form">
                <div class="col col-lg-11 col-xs-12" style= "margin: auto;">
                    <input type="password" class="confirma-senha form-control confirm-password" id="input-confirma" placeholder = "Confirme a nova senha" required name="input-confirma" >
                </div>
            </div>

            <div class="row row-form">
                <div class="card col-lg-11 col-xs-12" style= "margin: auto;">
                    <div class="card-body">
                        <br>
                            <h4>A nova senha deverá atender aos requisitos:</h4>
                            <p>- Mínimo de 8 caracteres.</p>
                            <p>- Deve haver ao menos uma letra maiúscula.</p>
                            <p>- Deve haver ao menos uma letra minúscula.</p>
                            <p>- Deve haver ao menos um número.</p>
                            <p>- Deve haver ao menos um caracter Especial</p>
                    </div>
                </div>
            </div>

            <br>
            <div style="text-align: center; " class="row row-form">
                <div class="col col-12">
                    <button type="button" id="botao-salvar" class="btn btn-success btn-lg btn-block">Alterar</button>
                </div>
            </div>
    </form>
</div>

<script>
    function onReady() {

        $('.nav-link').removeClass('active');
        $('.senha-link').addClass('active');
        $('#dropdown-operacional').addClass('active');

        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });


        
        var numeros = /([0-9])/;
        var alfabetoa = /([a-z])/;
        var alfabetoA = /([A-Z])/;
        var chEspeciais = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        var senhaForte = false;

        $('#input-senha').keyup(function(){

            var senha = $('#input-senha').val();

             if(senha.length<8) {
                $('#password-status').html("<span style='color: red; margin-left: 4%;'>Fraco, insira no mínimo 6 caracteres</span>");
            } else if(!senha.match(numeros)) {
                $('#password-status').html("<span style='color:orange; margin-left: 4%; margin-bottom: 0px;'><b>Insira um número</b></span>");  	
            } else if(!senha.match(alfabetoA)) {
                $('#password-status').html("<span style='color:orange; margin-left: 4%;'><b>Insira uma letra maiuscula</b></span>");
            } else if(!senha.match(chEspeciais)) {
                $('#password-status').html("<span style='color:orange; margin-left: 4%;'><b>Insira um caracter especial</b></span>");
            } else{
                $('#password-status').html("<span style='color:green; margin-left: 4%;'><b>Senha Forte</b></span>");
                senhaForte = true;
            } 
        });
        
        $('#botao-salvar').click(function(){

            var form = $('#form-senha').serialize();

            if(senhaForte){
                $.post('<?= base_url('Senhas/alterar') ?>', form, function(retorno) {

                    if(retorno.erro){

                        $('.retorno-erro').html("");
                        $('.retorno-erro').addClass('alert-warning');
                        $('.retorno-erro').html(`<strong>Atenção!</strong> ${retorno.mensagem}`);
                        $('.retorno-erro').show();
                        $('#input-senha').val("");
                        $('#input-confirma').val("");
                        $('#input-antiga').val("");
                    }else if (retorno.erro == false){
                        $('.retorno-erro').removeClass('alert-warning');
                        $('.retorno-erro').addClass('alert-success');
                        $('.retorno-erro').html(`${retorno.mensagem}`);
                        $('.retorno-erro').show();
                        $('#input-senha').val("");
                        $('#input-confirma').val("");
                        $('#input-antiga').val("");
                    }
                }, "json");

            } else {
                alert('A nova senha deverá cumprir com os requisitos!!')
                $('#input-senha').val("");
                $('#input-confirma').val("");
            }
        });
    }

</script>
 



