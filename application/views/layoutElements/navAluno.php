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

<nav style="background-color: #192A51; color: gray;" class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?= base_url('AlunosAgendamento') ?>"><img class="logo" src="<?= base_url('public/imagens/logopng.png') ?>" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse show" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li style="margin: 0 5%" class="nav-item">
                <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link a-link active" href="<?= base_url('Inicio') ?>">HOME</a>
            </li>
            <li style="margin: 0 5%" class="nav-item dropdown">
                <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link dropdown-toggle a-link" href="#" id="dropdown-ag-alunos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    AGENDAMENTO
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item drop-a agendamento-aluno-link" href="<?= base_url('AlunosAgendamento/agendar') ?>">AGENDAR</a>
                    <a class="dropdown-item drop-a agendamentos-link" href="<?= base_url("AlunosAgendamento/agendamentos/{$this->usuarioLogado->getAluno()->getId()}") ?>">MEUS AGENDAMENTOS</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <a class="btn btn-md btn-danger botao-sair" href="<?= base_url('Login/deslogar') ?>">
            <i class="fa fa-sign-out-alt icon-botao-sair"></i> SAIR</a>
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