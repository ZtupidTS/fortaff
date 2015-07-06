<div id="rodapé">
<?php
if(isset($_SESSION['sexo_css']))
{
	if($_SESSION['sexo_css'] == 'M')
	{?>
		<img src="../images/header_login_verde.jpg" alt="Header" class="header_login"/>
		<img src="../images/header_rd.jpg" alt="Header" class="header_login2"/>
		<div id="rodapé_centro">
		<p> &#160 &#169 2011 JRE - Grupo 609 </p>
		</div> 
		<?php
	}else{?>
		<img src="../images/header_rd_fem.png" alt="Header" class="header_login"/>
		<img src="../images/header_rd_fem.png" alt="Header" class="header_login2"/>
		<div id="rodapé_centro">
		<p> &#160 &#169 2011 JRE - Grupo 609 </p>
		</div>
		<?php
	}
}else{?>
	<img src="../images/header_login_verde.jpg" alt="Header" class="header_login"/>
	<img src="../images/header_rd.jpg" alt="Header" class="header_login2"/>
	<div id="rodapé_centro">
	<p> &#160 &#169 2011 JRE - Grupo 609 </p>
	</div>  
	<?php
}?>
</div>