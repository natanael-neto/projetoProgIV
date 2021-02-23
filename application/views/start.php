<nav style="background-color: #192A51; color: gray;" class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="http://www.google.com.br" target="_blank"><img class="logo" src="<?= base_url() . "public/logo.png" ?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <button type="button" class="btn btn-sm botaoEntrar">
            ENTRAR
        </button>
    </div>
</nav>

<!-- IMAGEM SUPERIOR -->
<div class="jumbotron jumb-image">
    <h1 class="display-4 jumb-titulo">ACADEMIA SISCTRL</h1>
    <h1 class="display-6 jumb-descricao">A MELHOR ACADEMIA DA CIDADE</h1>
    <hr style="background-color: gray" class="my-4">
    <a class="btn btn-lg jumb-botao" href="#" role="button">CONHEÇA NOSSOS SERVIÇOS</a>
</div>

<div style="margin-top: 30px" class="container secao">
    <!-- DIVISÓRIA -->
    <div class="row divisoria align-items-center">
        <div class="col mx-auto text-center">
            <h3 class="nomeDivisoria">SOBRE</h3>
            <img class="img-fluid center-block" src="<?= base_url() . "public/divisoria.svg" ?>">
        </div>
    </div>

    <!-- SEÇÃO 1 -->

    <div class="row">
        <div style="margin-bottom: 20px;" class="col-lg-6 col-sm-12">
            <img class="img-fluid" src="<?= base_url() . "public/secao1.png" ?>" />
        </div>
        <div class="col col-lg-6 col-sm-12">
            <span class="titulo-secao-1">MUSCULAÇÃO</span>
            <p class="texto-secao-1">
                A musculação é um tipo de exercício realizado com pesos de diversas cargas,
                amplitude e tempo de contração,
                o que faz dela uma atividade física indicada para pessoas de diversas idades e com diferentes objetivos.
                <br><br>
                A musculação está em alta nos dias atuais, além de ajudar a queimar gordura antes e após o treino, trabalha os músculos e modela o corpo deixando-o mais firme e bonito.
                <br><br>
                O treinamento com pesos auxilia no emagrecimento, aumenta o gasto calórico diário e estimula o metabolismo.
                Previne a osteoporose, por estimular a produção de massa óssea.
                Pode evitar o diabetes, já que o aumento de massa muscular queima mais glicose.
            </p>
        </div>
    </div>
</div>

<div class="container secao">
    <!-- DIVISÓRIA -->
    <div class="row divisoria align-items-center">
        <div class="col mx-auto text-center">
            <h3 class="nomeDivisoria">SERVIÇOS</h3>
            <img class="img-fluid center-block" src="<?= base_url() . "public/divisoria.svg" ?>">
        </div>
    </div>

    <!-- SEÇÃO 2 -->
    <div class="row">
        <div class="col-12">
            <div class="card-deck">
                <div class="card">
                    <div class="embed-responsive-4by3 embed-responsive">
                        <img src="<?= base_url() . "public/crossfit-card.jpg" ?>" class="embed-responsive-item card-img-top img-adjusted card-imagem">
                    </div>
                    <div class="card-body card-texto">AULAS DE CROSSFIT</div>
                </div>
                <div class="card">
                    <div class="embed-responsive-4by3 embed-responsive">
                        <img src="<?= base_url() . "public/funcional-card.jpg" ?>" class="embed-responsive-item card-img-top img-adjusted card-imagem">
                    </div>
                    <div class="card-body card-texto">AULAS DE FUNCIONAL</div>
                </div>
                <div class="card">
                    <div class="embed-responsive-4by3 embed-responsive">
                        <img src="<?= base_url() . "public/musculacao-card.jpg" ?>" class="embed-responsive-item card-img-top img-adjusted card-imagem">
                    </div>
                    <div class="card-body card-texto">AULAS DE MUSCULAÇÃO</div>
                </div>
                <div class="card">
                    <div class="embed-responsive-4by3 embed-responsive">
                        <img src="<?= base_url() . "public/danca-card.png" ?>" class="embed-responsive-item card-img-top img-adjusted card-imagem">
                    </div>
                    <div class="card-body card-texto">AULAS DE DANÇA</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container secao">
    <!-- DIVISÓRIA -->
    <div class="row divisoria align-items-center">
        <div class="col mx-auto text-center">
            <h3 class="nomeDivisoria">CONTATO</h3>
            <img class="img-fluid center-block" src="<?= base_url() . "public/divisoria.svg" ?>">
        </div>
    </div>

    <!-- SEÇÃO 2 -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-contato" role="alert">
                A simple secondary alert—check it out!
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-contato" role="alert">
                A simple secondary alert—check it out!
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-contato" role="alert">
                A simple secondary alert—check it out!
            </div>
        </div>
        <div class="col-12">
            <div class="alert alert-contato" role="alert">
                A simple secondary alert—check it out!
            </div>
        </div>
    </div>
</div>