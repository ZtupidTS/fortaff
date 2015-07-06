<?php include 'includes/cabecalho.php';?>

	 
	<div data-role="page">
		<div data-role="header">
			<h1>Login</h1>
			<img src="images/icon.png"/>					
		</div>
		 
		<div data-role="content">
			<form data-ajax="false" method="post" action="verif_login.php">
				<ul data-role="listview">
					<li>
						<div data-role="fieldcontain">
							<label for="name">Login:</label>
							<input type="text" name="login" id="login" value=""/>
						</div>
					</li>
					<li>
						<div data-role="fieldcontain">
							<label for="name">Palavra passe:</label>
							<input type="password"" name="password" id="password" value=""/>
						</div>
					</li>
					<li>
						<button data-theme="b" id="submit" type="submit">Entrar</button>
					</li>
				</ul>
			</form>
		<?php
		if(isset($_SESSION['mensagem']))
		{
			echo '1';
			?>
			<script>messagePopup('<?= $_SESSION['mensagem'];?>');</script>
			<?php
			unset($_SESSION['mensagem']);
		}		
		?>
		

<?php include 'includes/rodape.php';?>