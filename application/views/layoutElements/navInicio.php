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

<div class="div-external-nav">
    <nav style="background-color: #192A51; color: gray;" class="navbar navbar-expand-md navbar-dark fixed-top">
        <a style="margin-right: 0" class="navbar-brand" href="<?= base_url('Inicio') ?>">
            <img class="logo" src="<?= base_url('public/imagens/logopng.png') ?>">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse show" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li style="margin: 0 5%" class="nav-item">
                    <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link a-link active" href="<?= base_url('Inicio') ?>">HOME</a>
                </li>
                <li style="margin: 0 5%" class="nav-item dropdown">
                    <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link dropdown-toggle a-link" href="#" id="dropdown-cadastros" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CADASTROS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item drop-a professores-link" href="<?= base_url('Professores') ?>">PROFESSORES</a>
                        <a class="dropdown-item drop-a alunos-link" href="<?= base_url('Alunos') ?>">ALUNOS</a>
                        <?php if ($this->usuarioLogado->getPerfil()->getNome() == 'admin' ) : ?>
                            <a class="dropdown-item drop-a funcionarios-link" href="<?= base_url('Funcionarios') ?>">FUNCIONÁRIOS</a>
                        <?php endif; ?>
                    </div>
                </li>
                <li style="margin: 0 5%" class="nav-item dropdown">
                    <a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link dropdown-toggle a-link" href="#" id="dropdown-operacional" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        OPERACIONAL
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item drop-a agendamentos-link" href="<?= base_url('Agendamentos') ?>">AGENDAMENTOS</a>
                        <a class="dropdown-item drop-a modalidades-link" href="<?= base_url('Modalidades') ?>">MODALIDADES</a>
                        <a class="dropdown-item drop-a planos-link" href="<?= base_url('Planos') ?>">PLANOS</a>
                        <a class="dropdown-item drop-a aulas-link" href="<?= base_url('Aulas') ?>">AULAS</a>
                    </div>
                </li>
            </ul>
            <a class="btn btn-md btn-danger botao-sair" href="<?= base_url('Login/deslogar') ?>">
                <i class="fa fa-sign-out-alt icon-botao-sair"></i> SAIR</a>
        </div>
    </nav>
</div>

<script>
    function onReady() {
        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    }
</script>