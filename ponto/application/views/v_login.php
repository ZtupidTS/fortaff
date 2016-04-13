<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>Bemvindo Ao Ponto</title>
	<link rel="stylesheet" href="<?= base_url('includes/bootstrap/css/bootstrap.min.css')?>">	
	
	<!-- script js -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?= base_url('includes/bootstrap/js/bootstrap.min.js') ?>"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!--[if lt IE 9]> -->
    	<script src="<?= base_url('includes/bootstrap/js/html5shiv.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/respond.js') ?>"></script>
</head>

<body>
	
	<div class="container col-md-3 col-md-offset-4">
		<?php
		if(isset($password) && $password == "change")
		{?>
			<form id="identicalForm" class="form-signin" role="form" method="post" action="<?= base_url('login/changepass') ?>">
	        		<img src="<?= base_url('images/eleclerc.jpg');?>" height="130px" width="450px" />
	        		<h4>Introduza a sua nova password nos 2 rectangulos</h4>
	        		<input type="password" class="form-control" placeholder="Palavra Passe" required autofocus name="password">
	        		<input type="password" class="form-control" placeholder="Repetir Palavra Passe" required name="confirmPassword">
	        		<button class="btn btn-lg btn-primary btn-block" type="submit">Confirmar</button>
	        		<?php if (isset($erro)){ ?>
					<div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
				<?php } ?>
	      		</form>
	      		<?php
		}else{?>
			<form class="form-signin" role="form" method="post" action="<?= base_url('login/entrar') ?>">
	        		<img src="<?= base_url('images/eleclerc.jpg');?>" height="130px" width="450px" />
	        		<input type="number" class="form-control" min="1" placeholder="Numero Utilizador" required autofocus name="number_user">
	        		<input type="password" class="form-control" placeholder="Palavra Passe"  name="password">
	        		<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
	        		*Não se esquecer de sair ao fim
	        		<?php if (isset($erro)){ ?>
					<div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
				<?php } ?>
	      		</form>
		      	<?php 
	    	}?>
    	</div>
</body>
</html>

