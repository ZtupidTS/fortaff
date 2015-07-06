<?php include 'includes/cabecalho.php';?>
	
	<!-- corpo -->
	<div class="estrutura">	
		<div class="conteudo">
			<h1 class="titulo">Recuperar Palavra-Passe</h1>
			
			<form method="post" action="verif_recup_pass.php">
				<table class="tabela">	
					<tr>
						<td class="password">E-mail:</td> 
						<td><input type="text" name="email" class="frm" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="60" required></td>
					</tr>
				</table>
				<input type="submit" name="Submeter" value="Submeter" class="botao">
			</form>
		</div>
		
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
		
	</div>
	
	</body>
</html>