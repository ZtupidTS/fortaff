<?php 
include 'includes/cabecalho.php';
include 'includes/criararraypontos.php';
?>
	
	<!-- corpo -->
	

	<div id="mapa">
		<script type="text/javascript" language="javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript" language="javascript" src="js/arraypontos.js"></script>
		<script type="text/javascript" language="javascript" src="js/googlemaps.js"></script>
		<script type="text/javascript" language="javascript">
		function mudaTipo()
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
					$("link").innerHTML=xhr.responseText;
				}
			}
			var tipo = $("tipo").value;
			xhr.open("GET","ajax/gmapsajax.php?tipo="+tipo,true);
			xhr.send();
		}
		</script>
		
		
		<div class="titulo"> Google Maps </div>
		<select name="tipo" id="tipo" onchange="mudaTipo();">
			<option value="Provas">Provas</option>
			<option value="Eventos">Eventos</option>
		</select>
		<span name="link" id="link"></span>
		<span id="nova_rota">
			<button class="but�o_op��es2" type="button" onClick="initialize()">Nova Rota</button>
		</span>		
		
		<div id="map_canvas"></div>
		<p> Selecione o modo de transporte: 
			<select id="mode" onchange="calcRoute();">
				<option value="DRIVING">Carro</option>
				<option value="WALKING">A p�</option>
				<option value="BICYCLING">Bicicleta</option>
			</select>
			
		</p>
		<div id="directionsPanel"></div>
				
		<!-- para inicializar o script do mapa ao fim de carregar a pagina -->
		<script>
			initialize();
			mudaTipo();
		</script>
	</div>
		<!-- em baixo -->
		<?php include 'includes/rodape.php';?>
</html>