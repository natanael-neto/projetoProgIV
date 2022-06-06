<!DOCTYPE html>
<html lang="pt-BR">

<head>
	 <?php include APPPATH . 'views/layout/head.php' ?>
</head>

<body>
	<div id="content">
		<?php 
			isset($this->usuarioLogado) && $this->usuarioLogado->getPerfil()->getNome() == 'aluno' ? include APPPATH . 'views/layoutElements/navAluno.php' : include APPPATH . 'views/layoutElements/navWelcome.php'
		?>

		<?= $contents ?>
		<?php include APPPATH . 'views/layoutElements/footer.php' ?>
		<?php include APPPATH . 'views/layout/foot.php' ?>
	</div>
</body>

<html>