<body>
	<div id="topo">
		<div id="topo_interno">
			<div id="logo"> 
				<a href="/pw606/index.php"> <img src="/pw606/img/logo.png" alt="Logo JO" /> </a>
			</div>
			<div id="sidebar">
<?php
	// Se o nº dias for positivo mostra o relogio
	if($jo_Date->totaldays > 0) {
?>
						<div id="contador">
									<span>Faltam:</span></br>
									<div class="contador"><span id="joDD"><?= $jo_Date->days ?></span>d</div>
									<div class="contador"><span id="joHH"><?= $jo_Date->hours ?></span>h</div>
									<div class="contador"><span id="joII"><?= $jo_Date->mins ?></span>m</div>
									<div class="contador"><span id="joSS"><?= $jo_Date->secs ?></span>s</div>
						</div>
<?php
	}
?>
			</div>
		</div>
	</div>
			<div id="horizontalmenu">
				<ul id="nav-one" class="dropmenu"> 
					<li id="dropmenu_menu"> 
						<a href="<?= rootPath('public/index.php', 1); ?>">Home</a> 
					</li> 
					<li class="dropmenu" id="dropmenu_menu"> 
						<a href="#">Jogos Olímpicos</a> 
						<ul> 
							<li><a href="<?= rootPath('public/info.php', 1); ?>">Apresentação</a></li> 
							<li><a href="<?= rootPath('public/history.php', 1); ?>">História</a></li> 
							<li><a href="<?= rootPath('public/contacts.php', 1); ?>">Contactos</a></li>
							<li><a href="<?= rootPath('public/modalidades/index.php', 1); ?>">Modalidades</a></li>
						</ul> 
					</li> 
					<li id="dropmenu_menu"> 
						<a href="#">Participantes</a> 
						<ul> 
							<li><a href="<?= rootPath('public/delegacoes/index.php', 1); ?>">Delegações</a></li> 
							<li><a href="<?= rootPath('public/equipas/index.php', 1); ?>">Equipas</a></li> 
							<li><a href="<?= rootPath('public/elementos/index.php', 1); ?>">Elementos</a></li> 
						</ul> 
					</li>  
					<li id="dropmenu_menu"> 
						<a href="<?= rootPath('public/provas/index.php', 1); ?>">Provas</a> 
					</li>
					<li id="dropmenu_menu"> 
						<a href="<?= rootPath('public/eventos/index.php', 1); ?>">Eventos</a> 
					</li>
					<li id="dropmenu_menu"> 
						<a href="<?= rootPath('public/locais/index.php', 1); ?>">Locais</a> 
					</li>
					<li id="dropmenu_login">
						<a href="#"><img id="user-icon" src="/pw606/img/icon_utilizador.png" /><?= $user_authenticated ? 'minha conta' : 'login' ?></a>
<?php
	if ($user_authenticated) {
?>
						<ul style="width:198px;">
							<li><a href="<?= rootPath('myacount/index.php', 1); ?>"><?= $current_user['nome'] ?></a></li>
							<li><a href="<?= rootPath('myacount/ticket/index.php', 1); ?>">Os meus bilhetes</a></li>
							<li><a href="<?= rootPath('myacount/sugestions/index.php', 1); ?>">Sugestões/Reclamações</a></li>
							<li><a href="<?= rootPath('myacount/logout.php', 1); ?>?url=<?= $_SERVER['SCRIPT_NAME'] ?>">Terminar Sessão</a></li>
						</ul>
<?php
	} else {
?>
						<div class="login">
							<form action="/pw606/myacount/authenticate.php?url=<?= $_SERVER['SCRIPT_NAME'] ?>" method="post">
								<label for="txtuser">Username: </label>
								<input id="txtuser" type="text" name="user"/>
								<label for="txtpassword">Password: </label>
								<input id="txtpassword" type="password" name="password"/>
								<input type="submit" value="Login">
								<a id="login_a" href="<?= rootPath("public/register.php", 1) ?>">Registar</a>
							</form>
						</div>
<?php
	}
?>
					</li> 			
				</ul>
			</div>
	<div id="css-color">
		<div id="css-color-select">
			<div class="css-blue">
				<a href="#" class="switchCss" title="Tema azul" rel="blue.css" >CSS Blue</a>
			</div>
			<div class="css-green">
				<a href="#" class="switchCss" title="Tema verde" rel="green.css" >CSS Green</a>
			</div>
			<div class="css-yellow">
				<a href="#" class="switchCss" title="Tema amarelo" rel="yellow.css" >CSS Yellow</a>
			</div>
		</div>
	</div>
	<div id="main">
		<div id="content-background">
			<div id="content-bg">
					<div id="content-holder">
						<div id="content">