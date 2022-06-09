<style>
    .drop-a {
        color: #192A51;
        font-weight: 600;
    }

    .active {
        background-color: #21897E;
        border-radius: 15px;
    }

    .div-external-nav {
        margin-bottom: 70px;
    }
</style>

    <nav style="background-color: #192A51; color: gray;" class="navbar navbar-expand-lg navbar-dark fixed-top ">

        <a style="margin-left: 15px; float: left; margin-righ: 20px;t" class="navbar-brand" href="<?= base_url('Inicio') ?>">
            <img src="<?= base_url('public/imagens/logopng.png') ?>" width="120" height="48" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">

		    <ul class="navbar-nav mr-auto">
			  	<li style="margin: 0 5%" class="nav-item">
			        <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link a-link active" href="<?= base_url('Inicio') ?>">HOME</a>
			    </li>

			    <li style="margin: 0 5%" class="nav-item dropdown">
			        <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link dropdown-toggle a-link" href="#" id="dropdown-operacional" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			            AGENDAMENTO
			        </a>

			        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
			            <a class="dropdown-item drop-a agendamentos-link" href="<?= base_url('AlunosAgendamento/agendar') ?>">AGENDAR</a>
			            <a class="dropdown-item drop-a modalidades-link" href="<?= base_url("AlunosAgendamento/agendamentos/{$this->usuarioLogado->getAluno()->getId()}") ?>">MEUS AGENDAMENTOS</a>
		            </div>
			    </li>
			</ul>

            <div class="inline">
			    <a class="btn btn-md btn-danger botao-sair" href="<?= base_url('Login/deslogar') ?>">
			        <i class="fa fa-sign-out-alt icon-botao-sair"></i> SAIR
			    </a>
			</div>
			    
		</div>
	</nav>

<script>
    function onReady() {
        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    }
</script>