<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>HH</title>

	<link rel="stylesheet" href="<?= base_url('includes/bootstrap/css/bootstrap.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/bootstrap/css/bootstrap-datetimepicker.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/css/lobibox.css') ?>">
	<link rel="stylesheet" href="<?= base_url('includes/css/datatables.min.css') ?>">
	
	<!-- script js -->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
	<script src="<?= base_url('includes/bootstrap/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('includes/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('includes/bootstrap/js/html5shiv.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/respond.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/bootstrap-datetimepicker.pt.js') ?>"></script>
    	<script src="<?= base_url('includes/bootstrap/js/bootstrap-datetimepicker.js') ?>"></script>
      	
      	<!-- O js dos popups -->
      	<script src="<?= base_url('includes/js/jquery.noty.packaged.min.js') ?>"></script>
      	<script src="<?= base_url('includes/js/lobibox.min.js') ?>"></script>
      	<script src="<?= base_url('includes/js/datatables.min.js') ?>"></script>
      	
      	<!-- Meus scripts -->
      	<script src="<?= base_url('includes/js/submitform.js') ?>"></script>
      	<script src="<?= base_url('includes/js/exporttoexcel.js') ?>"></script>
      	<script src="<?= base_url('includes/js/diversos.js') ?>"></script>
      	<script src="<?= base_url('includes/js/downloadfile.js') ?>"></script>
</head>
<body>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><img src="<?= base_url('images/zoom.png');?>" height="30px" width="150px" /></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!--<li><a href="#">Menu</a></li>
				<li><a href="#">Link</a></li>-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-submenu">
							<a href="#">Jogadores</a>
							<ul class="dropdown-menu">
								<li><a href="<?= base_url('Home/createplayer') ?>">Criar</a></li>
        							<li><a href="<?= base_url('Home/viewmodifyplayer') ?>">Alterar</a></li>
							</ul>
						</li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-submenu">
							<a href="#">Resumo</a>
							<ul class="dropdown-menu">
								<li><a href="<?= base_url('home/resumototais') ?>">Horas Totais</a></li>
        							<li><a href="<?= base_url('home/resumodiario') ?>">Diario</a></li>
        							<li><a href="<?= base_url('home/resumosemanal') ?>">Semanal</a></li>
							</ul>
						</li>
						<li role="separator" class="divider"></li>
						<li><a href="<?= base_url('home/feriados') ?>">Feriados</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?= base_url('home/contractos') ?>">Contratos</a></li>
						<!-- <li role="separator" class="divider"></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">One more separated link</a></li>-->
					</ul>
					<li><a href="<?= base_url('home/viewlog') ?>">Logs</a></li>
					<li><a href="<?= base_url('home/vexporttosage') ?>">Export To Sage</a></li>
				</li>
			</ul>
			<!--<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>-->
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?= base_url('login/logout') ?>"><?= $this->session->userdata('nome').'(sair)' ?></a></li>				
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>