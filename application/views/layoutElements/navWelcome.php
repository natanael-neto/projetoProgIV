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

	<nav class="navbar navbar-expand-lg navbar-dark fixed-top div-external-nav">
		<a style="margin-left: 15px; float: left;" class="navbar-brand" href="<?= base_url() ?>">
    		<img src="<?= base_url('public/imagens/logopng.png') ?>" width="135" height="50"  alt="Logo">
  		</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">

		<?php if(isset($exibir)  && !$exibir) : ?>

		  	<ul class="navbar-nav mr-auto">

            	<li style="margin: 0 6%" class="nav-item  text-nowrap">
		        	<a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link scroll" href="#informa">INFORME-SE</a>
		      	</li>
		      	<li style="margin: 0 6%" class="nav-item">
		        	<a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link scroll" href="#aulas">SERVIÇOS </a>
		      	</li>
		      	<li style="margin: 0 6%" class="nav-item">
		        	<a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link scroll" href="#unidades">UNIDADES</a>
		      	</li>
		      	<li style="margin: 0 6%" class="nav-item">
		       		<a style="color:aliceblue; font-size: 18px; font-weight: 600;" class="nav-link scroll" href="#contato">CONTATO</a>
		      	</li>
		    </ul>
		

		    <div class="inline">
		        <a href="<?= base_url('Login') ?>" class="btn btn-sm botaoEntrar">
		         	LOGIN
		        </a>
		    </div>

		<?php endif;?>
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