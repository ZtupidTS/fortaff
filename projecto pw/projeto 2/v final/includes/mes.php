<select name="mes">
<?php
for($i=1; 0 < $i && $i < 13;$i++)
{
	$igualdade = true;
	if(isset($_SESSION['mes']))
	{
		if($_SESSION['mes'] == $i)
		{
			if($i < 10)
			{
				$i = '0' . $i;
				?><option value="<?= $i; ?>" selected="selected"><?= $i; ?></option><?php
			}else{
				?>
				<option value="<?= $i; ?>" selected="selected"><?= $i; ?></option>
				<?php
			}
			$igualdade = false;
		}
	}
	if($igualdade)
	{
		if($i < 10)
		{
			$i = '0' . $i;
			?><option value="<?= $i; ?>"><?= $i; ?></option><?php
		}else{
			?>
			<option value="<?= $i; ?>"><?= $i; ?></option>
			<?php
		}
	}
}
?>
</select>