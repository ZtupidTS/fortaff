<div id="cabeçalho">
<?php
if(isset($_SESSION['sexo_css']))
{
	if($_SESSION['sexo_css'] == 'M')
	{?>
		<img src="../images/header_rd.jpg" alt="header"/> 
		<?php
	}else{?>
		<img src="../images/header_rd_fem.png" alt="header"/>
		<?php
	}
}else{?>
	<img src="../images/header_rd.jpg" alt="header"/> 
	<?php
}?>
</div>