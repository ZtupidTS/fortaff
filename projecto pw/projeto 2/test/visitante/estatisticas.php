<?php include 'includes/cabecalho.php';?>
	<script type="text/javascript" language="javascript">
	function Visualizar(tabela)
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			var xhr=new XMLHttpRequest();
		}else{// code for IE6, IE5
			var xhr=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhr.onreadystatechange=function()
		{
			if (xhr.readyState==4 && xhr.status==200)
			{
				
				$("txtchange").innerHTML=xhr.responseText;
				//var pager = new Pager('results', 4); 
				//pager.init(); 
				//pager.showPageNav('pager', 'pageNavPosition'); 
				//pager.showPage(1);
			}
		}
		xhr.open("GET","ajax/estatistica.php?tabela="+tabela,true);
		xhr.send();
	}	
	</script>
	
	<!-- corpo -->
	<div class="titulo"> Estatísticas </div>
			<button class="butão_opções1" type="button" onclick="Visualizar('global')">Globais</button>
			<button class="butão_opções1" type="button" onclick="Visualizar('medalhas')">Medalhas</button>
			<button class="butão_opções1" type="button" onclick="Visualizar('idade')">Idade Média</button>
		
		<div id="txtchange">
		<div id="txtchange2">&nbsp;</div>
		</div>
		
		<?php include 'includes/paginacao_tabela.php';?>
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>

</html>