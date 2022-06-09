<!DOCTYPE html>
<html lang="pt-BR">

<head>
	 <?php include APPPATH . 'views/layout/head.php' ?>
</head>

<body>
	<div id="content">

		<?php
		if(isset($this->usuarioLogado) && $this->usuarioLogado->getPerfil()->getNome() == 'aluno'){
			include APPPATH . 'views/layoutElements/navAluno.php';
		}elseif(isset($this->usuarioLogado) && $this->usuarioLogado->getPerfil()->getNome() == 'funcionario' or isset($this->usuarioLogado) && $this->usuarioLogado->getPerfil()->getNome() == 'admin'){
			include APPPATH . 'views/layoutElements/navInicio.php';
		}else{
			include APPPATH . 'views/layoutElements/navWelcome.php';
		}?>

		<?= $contents ?>
		<?php include APPPATH . 'views/layoutElements/footer.php' ?>
		<?php include APPPATH . 'views/layout/foot.php' ?>
	</div>
</body>

<html>