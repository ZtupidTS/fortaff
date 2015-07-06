<body>
	<div id="topo">
			<div id="logo"> 
				<a href="/pw606/index.php"> <img src="/pw606/img/logo.png" alt="Logo JO" /> </a>
			</div>
	</div>
	<div id="main">
		<div id="content-background">
			<div id="content-bg">
				
					<div id="sidebar">
						<div id="user">
							<img class="user" style="width:50px;"
								 title="<?= $user_authenticated ? $current_user['pais_nome'] : "" ; ?>"
								 src="/pw606/img/countries/128/<?= $user_authenticated ? $current_user['id_pais'] : "generic" ; ?>.png"/>
								<div id="user_links">						
<?php
	if ($user_authenticated) {
?>
										<?= $current_user['nome_responsavel'] ?> (<?= $current_user['login'] ?>)
										<a href="/pw606/<?= $user_isAdmin ? 'co' : 'rd' ?>/logout.php">Logout</a>
<?php
	} else {
?>
										<a href="/pw606/<?= $user_isAdmin ? 'co' : 'rd' ?>/index.php">Login</a>
<?php
	}
?>		
								</div>
						</div>
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
						<div id="verticalmenu" style="visibility:<?= $user_authenticated ? "visible" : "hidden" ; ?>;">
							<ul>
<?php if ($perfil == "co") { ?>
								<li><a href="/pw606/co/index.php" title="Home"><span>Home</span></a></li>
								<li><a href="/pw606/co/delegacoes/index.php" title="Home"><span>Delegações</span></a>
									<ul>
										<li><a href="edit.php" title="Nova Delegação"><span>Nova Delegação</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/elementos/index.php" title="Home"><span>Elementos</span></a>
									<ul>
										<li><a href="/pw606/co/elementos/edit.php" title="Novo Atleta"><span>Novo Atleta</span></a></li>
										<li><a href="/pw606/co/elementos/edit.php?auxiliar=" title="Novo Auxiliar"><span>Novo Auxiliar</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/equipas/index.php" title="Home"><span>Equipas</span></a>
									<ul>
										<li><a href="/pw606/co/equipas/edit.php" title="Nova Equipa"><span>Nova Equipa</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/modalidades/index.php" title="Home"><span>Modalidades</span></a>
									<ul>
										<li><a href="/pw606/co/modalidades/edit.php" title="Nova Modalidade"><span>Nova Modalidade</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/provas/index.php" title="Home"><span>Provas</span></a>
									<ul>
										<li><a href="/pw606/co/provas/edit.php" title="Nova Prova"><span>Nova Prova</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/eventos/index.php" title="Home"><span>Eventos</span></a>
									<ul>
										<li><a href="/pw606/co/eventos/edit.php" title="Novo Evento"><span>Novo Evento</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/locais/index.php" title="Home"><span>Locais</span></a>
									<ul>
										<li><a href="/pw606/co/locais/edit.php" title="Novo Local"><span>Novo Local</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/co/sugestions/index.php" title="Home"><span>Sugestões</span></a>
								</li>
<?php } else if ($perfil == "rd") { ?>
								<li><a href="/pw606/rd/index.php" title="Home"><span>Home</span></a></li>
								<li><a href="/pw606/rd/delegacoes/index.php" title="Home"><span>Delegações</span></a>
								</li>
								<li><a href="/pw606/rd/elementos/index.php" title="Home"><span>Elementos</span></a>
									<ul>
										<li><a href="/pw606/rd/elementos/edit.php" title="Novo Atleta"><span>Novo Atleta</span></a></li>
										<li><a href="/pw606/rd/elementos/edit.php?auxiliar=" title="Novo Auxiliar"><span>Novo Auxiliar</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/rd/equipas/index.php" title="Home"><span>Equipas</span></a>
									<ul>
										<li><a href="/pw606/rd/equipas/edit.php" title="Nova Equipa"><span>Nova Equipa</span></a></li>
									</ul> 
								</li>
								<li><a href="/pw606/rd/provas/index.php" title="Home"><span>Provas</span></a>
									<ul>
										<li><a href="/pw606/rd/provas/edit.php" title="Nova Prova"><span>Nova Prova</span></a></li>
									</ul> 
								</li>
<?php } ?>
							</ul>
						</div>
					</div>
					<div id="content-holder">
						<div id="content">