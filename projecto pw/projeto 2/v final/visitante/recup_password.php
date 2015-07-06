<?php include 'includes/cabecalho.php';?>
	
	<!-- corpo -->
	
		<div class="conteudo">
			<h1 class="titulo">Recuperar Palavra-Passe</h1>
		<div id="form_rec_pass">
			<form method="post" action="verif_recup_pass.php">
				<table class="tabela_rec_pass">	
					<tr class="password">
						<td >E-mail:</td> 
						<td><input type="text" name="email" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="60" required></td>
					</tr>
				</table>
				<input type="submit" name="Submeter" value="Submeter" class="botao">
			
			</form>
		</div>
		
		</div>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>