<select name="<?php echo $_SESSION['minutos'];?>">
<?php
for($i=0; 0 <= $i && $i < 60;$i++)
{
	$igualdade = true;
	if(isset($_SESSION['alt_minutos']))
	{
		if($_SESSION['alt_minutos'] == $i)
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