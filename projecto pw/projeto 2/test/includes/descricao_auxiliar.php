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
	<td>Função:</td>
	<td>
	<?php
	if(isset($_SESSION['funcao']))
	{?>
		<input type="text" name="funcao" value="<?= $_SESSION['funcao'];?>"size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required>
		<?php
	}else{?>
		<input type="text" name="funcao" size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required>
		<?php
	}?>	
	</td>
</tr>
<tr>
	<td>Habilitações literarias:</td>
	<td>
	<?php
	if(isset($_SESSION['habilit_literarias']))
	{?>
		<input type="text" name="habilit_literarias" value="<?= $_SESSION['habilit_literarias'];?>"size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required>
		<?php
	}else{?>
		<input type="text" name="habilit_literarias" size="30" onblur="this.className='frm'" onfocus="this.className='frm-on'" maxlength="30" required>
		<?php
	}?>	
	</td>
</tr>