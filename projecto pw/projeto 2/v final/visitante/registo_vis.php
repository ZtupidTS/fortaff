<?php include 'includes/cabecalho.php';?>

	<!-- corpo -->
	<script>
	var n = 5;
	function over_estrela(nb){
		elemClassement = document.getElementById("classement");
		tabImg = elemClassement.getElementsByTagName("img");
		
		if (nb > 0)
			for (i=0; i<nb; i++)
				tabImg[i].src="../images/estrela/estrela_over.png";
		for (i=nb; i<n; i++)
			tabImg[i].src="../images/estrela/estrela_out.png";
	}

	function out_estrela(nb){
		elemClassement = document.getElementById("classement");
		tabImg = elemClassement.getElementsByTagName("img");
		
		for (i=0; i<nb; i++)
			tabImg[i].src="../images/estrela/estrela_out.png";
		for (i=0; i<n; i++){
			if (tabImg[i].value == "on")
				tabImg[i].src="../images/estrela/estrela.png";
		}
	}

	function on_estrela(nb,cod_sessao){
		elemClassement = document.getElementById("classement");
		tabImg = elemClassement.getElementsByTagName("img");
		
		for (i=0; i<nb; i++){
			tabImg[i].src="../images/estrela/estrela.png";
			tabImg[i].value="on";
		}
		for (i=nb; i<n; i++){
			tabImg[i].src="../images/estrela/estrela_out.png";
			tabImg[i].value="off";
		}
		window.location.href = "verif_evaluacao.php?estrela="+nb+"&cod="+cod_sessao;	
	}
	</script>
	
		<div id="form">
		<?php
		if(isset($_SESSION['nome_vis']))
		{?>
			<h1 class="titulo2">Alterar Registo</h1>
			<form id="form_table" method="POST" action="verif_alt.php">
				<table>
					<tr>
						<td><label class="form_col" for="nome">Nome :</label></td>
						<td><input value="<?= $_SESSION['nome_vis'];?>" name="nome" id="nome" type="text" required maxlength="30"><span class="tooltip">O nome tem de ter entre 2 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="apelido">Apelido :</label></td>
						<td><input value="<?= $_SESSION['apelido_vis'];?>" name="apelido" id="apelido" type="text" required maxlength="30"/><span class="tooltip">O apelido tem de ter entre 2 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="nif">NIF :</label></td>
						<td><input value="<?= $_SESSION['nif_vis'];?>" name="nif" id="nif" type="text" onkeydown="this.value = LugaresTotal(this.value)" required/ maxlength="9"><span class="tooltip">O Nif tem de ter 9 numeros</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="morada">Morada :</label></td>
						<td><input value="<?= $_SESSION['morada_vis'];?>" name="morada" id="morada" type="text" required maxlength="240"><span class="tooltip">A morada não pode ter mais que 240 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="telemovel">Telemovel :</label></td>
						<td><input value="<?= $_SESSION['telemovel_vis'];?>" name="telemovel" id="telemovel" type="text" onkeydown="this.value = LugaresTotal(this.value)" required maxlength="9"><span class="tooltip">O numero de telemóvel tem de ter 9 numeros</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="email1">Email :</label></td>
						<?php
						$email = explode("@", $_SESSION['email_vis']);
						?>
						<td><input value="<?= $email[0];?>" name="email1" id="email1" type="text" required>@<input value="<?= $email[1];?>" name="email2" id="email2" type="text" required/></td>
					</tr>
					<tr>
						<td><label class="form_col" for="login">Login :</label></td>
						<td><input value="<?= $_SESSION['login_vis'];?>" name="login" id="login" type="text" required maxLength="30"><span class="tooltip">O login tem de ter entre 4 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="psw">Palavra passe :</label></td>
						<td><input name="psw" id="psw" type="password" required maxLength="30"><span class="tooltip">A palavra passe tem de ter entre 4 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="psw2">Confirmar Palavra passe:</label></td>
						<td><input name="psw2" id="psw2" type="password" required maxLength="30"><span class="tooltip">As palavras passes não coincidem</span></td>
					</tr>
					<tr>
						<td colspan="2" class="gravar_alterações"><input type="submit" value="Gravar Alterações"/></td>
					</tr>
				</table>
			</form>
			<script type="text/javascript" language="javascript" src="js/formulario_inscricao.js"></script>
			<?php
		}else{?>
			<h1 class="titulo2">Novo Registo</h1>
			<form id="form_table" method="POST" action="verif_registo.php">
				<table>
					<tr>
						<td><label class="form_col" for="nome">Nome :</label></td>
						<td><input name="nome" id="nome" type="text" required maxlength="30"><span class="tooltip">O nome tem de ter entre 2 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="apelido">Apelido :</label></td>
						<td><input name="apelido" id="apelido" type="text" required maxlength="30"/><span class="tooltip">O apelido tem de ter entre 2 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="nif">NIF :</label></td>
						<td><input name="nif" id="nif" type="text" onkeydown="this.value = LugaresTotal(this.value)" required/ maxlength="9"><span class="tooltip">O Nif tem de ter 9 numeros</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="morada">Morada :</label></td>
						<td><input name="morada" id="morada" type="text" required maxlength="240"><span class="tooltip">A morada não pode ter mais que 240 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="telemovel">Telémovel :</label></td>
						<td><input name="telemovel" id="telemovel" type="text" onkeydown="this.value = LugaresTotal(this.value)" required maxlength="9"><span class="tooltip">O numero de telemóvel tem de ter 9 numeros</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="email1">Email :</label></td>
						<td><input name="email1" id="email1" type="text" required>@<input name="email2" id="email2" type="text" required/></td>
					</tr>
					<tr>
						<td><label class="form_col" for="login">Login :</label></td>
						<td><input name="login" id="login" type="text" required maxLength="30"><span class="tooltip">O login tem de ter entre 4 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="psw">Palavra passe :</label></td>
						<td><input name="psw" id="psw" type="password" required maxLength="30"><span class="tooltip">A palavra passe tem de ter entre 4 e 30 caracteres</span></td>
					</tr>
					<tr>
						<td><label class="form_col" for="psw2">Confirmar Palavra passe:</label></td>
						<td><input name="psw2" id="psw2" type="password" required maxLength="30"><span class="tooltip">As palavras passes não coincidem</span></td>
					</tr>
					<script type="text/javascript" language="javascript" src="js/formulario_inscricao.js"></script>
					<tr>
						<td><label class="form_col">Captcha:</label></td>
						<td>
							<img id="siimage" style="border: 1px solid #000; margin-right: 15px; height:30px; width: 100px" src="../securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
							<object type="application/x-shockwave-flash" data="../securimage/securimage_play.swf?audio_file=../securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" height="32" width="32">
								<param name="movie" value="../securimage/securimage_play.swf?audio_file=../securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000">
							</object>
							<a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '../securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="../securimage/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0"></a>
						</td>
					</tr>	
					<tr>
						<td  class="form_col">Enter Code:</td>
						<td>
							<input type="text" name="ct_captcha" size="12" maxlength="8" required/>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="gravar_alterações"><input type="submit" value="Validar"/><input type="reset" value="Limpar" /></td>
					</tr>
				</table>
			</form>
			<?php
		}?>	
		</div>
		<?php
		
		if(isset($_SESSION['nome_vis']))
		{
			$db = mysql_query("SELECT * FROM reserva_compra WHERE id_vis = '$_SESSION[id_vis]'");
			?>
			
			<h1 class="titulo">Compras e Reservas Efectuadas</h1>
			<table id="results">
				<tr>
					<th>Numero Da Reserva</th>
					<th>Género</th>
					<th>Lugares Reservados</th>
					<th>Evento/Prova</th>
					<th>Tipo</th>
					<th>Avaliação</th>
				</tr>
				<?php
				$class = 'linha_impar';
				while($dados = mysql_fetch_array($db))
				{?>
					<tr class="<?= $class;?>">	
						<td>
							<?= $dados['idreserva_compra'];?>
						</td>
						<td>
							<?php
							if($dados['tipo'] == 'PR')
							{
								echo 'Prova';
							}else{
								echo 'Evento';
							}
							?>
						</td>
						<td>
							<?= $dados['quant'];?>
						</td>
						<td>
							<?
							if($dados['tipo'] == 'PR')
							{
								$db2 = mysql_fetch_array(mysql_query("SELECT * FROM tipo_prova WHERE cod_prova = '$dados[cod_sessao]'"));
								echo $db2['nome_modalidade'];
							}else{
								$db2 = mysql_fetch_array(mysql_query("SELECT * FROM evento WHERE cod_evento = '$dados[cod_sessao]'"));
								echo $db2['designacao'].': '.$db2['descricao'];
							}							
							?>							
						</td>
						<td>
							<?= $dados['re_ou_com'];?>
						</td>
						<td>
							<?php
							if($dados['tipo'] == 'EV')
							{
								if($dados['re_ou_com'] == 'compra')
								{
									require_once '../funcao/dia_actual.php';
									$dia = dia_actual();
									if($db2['data'] < $dia)
									{
										$db_evento = mysql_query("SELECT * FROM classificacao_evento WHERE cod_evento = '$dados[cod_sessao]' and id_vis = '$_SESSION[id_vis]'");
										if(mysql_num_rows($db_evento) > 0)
										{
											$dados_evento = mysql_fetch_array($db_evento);
											$estrela = $dados_evento['classificacao'];
											include '../includes/estrelas.php';
										}else{
											?>
											<div id="classement" name="cls">
												<a href="#"><img src="../images/estrela/estrela_out.png" id="star" value="off" onMouseOver="over_estrela(1)" onMouseOut="out_estrela(1)" onClick="on_estrela(1,'<?= $dados['cod_sessao'];?>')"/></a>
												<a href="#"><img src="../images/estrela/estrela_out.png" id="star" value="off" onMouseOver="over_estrela(2)" onMouseOut="out_estrela(2)" onClick="on_estrela(2,'<?= $dados['cod_sessao'];?>')"/></a>
												<a href="#"><img src="../images/estrela/estrela_out.png" id="star" value="off" onMouseOver="over_estrela(3)" onMouseOut="out_estrela(3)" onClick="on_estrela(3,'<?= $dados['cod_sessao'];?>')"/></a>
												<a href="#"><img src="../images/estrela/estrela_out.png" id="star" value="off" onMouseOver="over_estrela(4)" onMouseOut="out_estrela(4)" onClick="on_estrela(4,'<?= $dados['cod_sessao'];?>')"/></a>
												<a href="#"><img src="../images/estrela/estrela_out.png" id="star" value="off" onMouseOver="over_estrela(5)" onMouseOut="out_estrela(5)" onClick="on_estrela(5,'<?= $dados['cod_sessao'];?>')"/></a>
											</div>
											<?php
										}
									}else{
										echo '--';
									}
								}else{
									echo '--';
								}
							}else{
								echo '--';
							}
							?>							
						</td>
					</tr>
					<?php
				}?>				
			</table>
			<?php
		}
		include 'includes/paginacao_tabela.php';
		?>
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
	