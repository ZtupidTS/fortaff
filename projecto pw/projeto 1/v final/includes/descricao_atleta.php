<tr>
	<td>Data Nascimento:</td> 
	<td>
	<select name="dia">
		<?php
		for($i=1; 0 < $i && $i < 32;$i++)
		{
			$igualdade = true;
			if(isset($_SESSION['dia']))
			{
				if($_SESSION['dia'] == $i)
				{
					?>
					<option value="<?= $i ?>" selected="selected"><?= $i ?></option>
					<?php
					$igualdade = false;
				}
			}
			if($igualdade)
			{
				?>
				<option value="<?= $i ?>"><?= $i ?></option>
				<?php
			}
		}
		?>
	</select>
	
	<select name="mes">
		<?php
		for($i=1; 0 < $i && $i < 13;$i++)
		{
			$igualdade = true;
			if(isset($_SESSION['mes']))
			{
				if($_SESSION['mes'] == $i)
				{
					?>
					<option value="<?= $i ?>" selected="selected"><?= $i ?></option>
					<?php
					$igualdade = false;
				}
			}
			if($igualdade)
			{
				?>
				<option value="<?= $i ?>"><?= $i ?></option>
				<?php
			}
		}
		?>
	</select>
	
	</select>
	<select name="ano">
		<?php
		for($i=1900; 1899 < $i && $i < $_SESSION['ano_actual'];$i++)
		{
			$igualdade = true;
			if(isset($_SESSION['ano']))
			{
				if($_SESSION['ano'] == $i)
				{
					?>
					<option value="<?= $i ?>" selected="selected"><?= $i ?></option>
					<?php
					$igualdade = false;
				}
			}
			if($igualdade)
			{
				?>
				<option value="<?= $i ?>"><?= $i ?></option>
				<?php
			}
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td>Peso:</td>
	<td>
		<select name="peso">
		<?php
		for($i=1; 0 < $i && $i < 350;$i++)
		{
			$igualdade = true;
			if(isset($_SESSION['peso']))
			{
				if($_SESSION['peso'] == $i)
				{
					?>
					<option value="<?= $i ?>" selected="selected"><?= $i ?> kg</option>
					<?php
					$igualdade = false;
				}
			}
			if($igualdade)
			{
				?>
				<option value="<?= $i ?>"><?= $i ?> kg</option>
				<?php
			}
		}
		?>
		</select>
	</td>
</tr>
<tr>
	<td>Altura:</td>
	<td>
		<select name="altura">
			<?php
			for($i=1; 0 < $i && $i < 300;$i++)
			{
				$igualdade = true;
				if(isset($_SESSION['altura']))
				{
					if($_SESSION['altura'] == $i)
					{
						?>
						<option value="<?= $i ?>" selected="selected"><?= $i ?> cm</option>
						<?php
						$igualdade = false;
					}
				}
				if($igualdade)
				{
					?>
					<option value="<?= $i ?>"><?= $i ?> cm</option>
					<?php
				}
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>Grupo Sanguineo:</td>
	<td>
		
		<select name="grupo_sanguineo">
			<?php
			$grupo_sanguineo = mysql_query("SELECT * FROM grupo_sanguineo");
			while($dados_gs = mysql_fetch_array($grupo_sanguineo))
			{
				$igualdade = true;
				if(isset($_SESSION['grupo_sanguineo']))
				{
					if($_SESSION['grupo_sanguineo'] == $dados_gs['grupo_sanguineo'])
					{
							?>
							<option value="<?= $dados_gs['grupo_sanguineo']; ?>" selected="selected"><?= $dados_gs['grupo_sanguineo']; ?></option>
							<?php
							$igualdade = false;
					}
				}
				if($igualdade)
				{
					?>
					<option value="<?= $dados_gs['grupo_sanguineo']; ?>"><?= $dados_gs['grupo_sanguineo']; ?></option>
					<?php
				}
			}
			?>
		</select>
	</td>
</tr>
