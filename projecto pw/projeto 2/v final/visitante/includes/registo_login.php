<div class="login">
	<ul id="nav">
		<script type="text/javascript" language="javascript">
		function submitFormulario()
		{
			document.login_formulario.submit();
		}		
		</script>
		<?php
		if(isset($_SESSION['nome_vis']))
		{
			#por a aparecer o texto com o nome do login
			
		}else{?>
				<form method="post" name="login_formulario" id="login_formulario" action="<?= $url_actual;?>">
					<table>
						<tr>
							<td>Login:</td> 
							<td><input type="text" name="login_log" size="10" maxlength="30" required class="form"></td>
							<td>Palavra Passe:</td> 
							<td><input type="password" name="password_log" size="10" maxlength="30" required class="form"></td>
							<td><a href="javascript:void(0)" onClick="submitFormulario()">Entrar</a></td>
							<td><a href="registo_vis.php">Registar-se</a></td>
							<td id="recuperar_pass"><a href="recup_password.php">Recuperar Palavra Passe</a></td>
						</tr>
					</table>					
				</form>
			<?php
		}
		?>
	</ul>
</div>