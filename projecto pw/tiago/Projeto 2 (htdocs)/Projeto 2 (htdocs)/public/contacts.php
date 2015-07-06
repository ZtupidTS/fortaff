<?php
	require_once '../includes/utils.php';
	include_once rootPath('includes/sijo/html_header.php', 1);
	include_once rootPath('includes/sijo/master_header.php', 1);
	//require_once rootPath('public/check_login.php', 1);
?>

<?php
?>
<h1>Contactos</h1>
	<div id="contatos">
		<span style="font-weight: bold;">Morada:</span><br/>
			One Churchill Place<br/>
			Canary Wharf<br/>
			London E14 5LN<br/>
			England<br/>
			<br/>
		<span style="font-weight: bold;">Contactos:</span><br/>
		020 3 2012 000<br/>
		<br/>
		<span style="font-weight: bold;">Endereço Electrónico:</span><br/>
		elisio.telmo.oliveira@gmail.com<br/>
		tiagodaraujo@hotmail.com<br/>
		danieloliveirapt@hotmail.com<br/>
		<br/>
		<span style="font-weight: bold;">Coordenadas GPS:</span><br/>
		Latitude: +51° 30' 18.54" N <br/>
		Longitude: -0° 0' 51.67"  W
	</div>
	<div id="mapas">
		<iframe width="650" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=pt-PT&amp;geocode=&amp;q=One+Churchill+Place+Canary+Wharf+London+E14+5LN&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=37.273371,86.572266&amp;ie=UTF8&amp;hq=One+Churchill+Place+Canary+Wharf+London+E14+5LN&amp;hnear=&amp;radius=15000&amp;t=m&amp;ll=51.50511,-0.01442&amp;spn=0.096165,0.222816&amp;z=12&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=pt-PT&amp;geocode=&amp;q=One+Churchill+Place+Canary+Wharf+London+E14+5LN&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=37.273371,86.572266&amp;ie=UTF8&amp;hq=One+Churchill+Place+Canary+Wharf+London+E14+5LN&amp;hnear=&amp;radius=15000&amp;t=m&amp;ll=51.50511,-0.01442&amp;spn=0.096165,0.222816&amp;z=12" style="color:#0000FF;text-align:left">Ver mapa maior</a></small>
	</div>

<?php
	include_once rootPath('/includes/sijo/master_footer.php', 1);
?>