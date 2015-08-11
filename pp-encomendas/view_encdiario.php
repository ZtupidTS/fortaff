<?php include 'includes/header.php'; ?>

<?php
//dia actual 
$date_atual = date('Y-m-d');
$date_mais8 = date("Y-m-d", strtotime($date_atual . ' + 8 days'));

$textmail = '<html><body>';

$table = encomendasGetByFiltro("pp_enc_datedone >= ".dbString($date_atual)." AND pp_enc_datedone <= ".dbString($date_mais8). " AND pp_enc_datalevantamento is NULL AND pp_enc_enable = 1", "pp_enc_datedone");

while ($row = foreachRow($table))
{
	$textmail .= '<h2 style="color:blue"> Encomenda Nº ' . $row['pp_enc_id'] . '</h2>';
	
	$textmail .= '<b>Data do levantamento da encomenda:</b> '.$row['pp_enc_datedone'].'<br/>';
	$textmail .= '<b>Nome do cliente:</b> '.$row['pp_enc_clientname'].'<br/>';
	$textmail .= '<b>Contacto do cliente:</b> '.$row['pp_enc_clientcontact'].'<br/>';
	$textmail .= '<b>Data de criação da encomenda:</b> '.$row['pp_enc_dateenc'].'<br/>';
	if($row['pp_enc_idbolonosso'] == '')
	{
		$textmail .= '<b>Fez a selecção através de um bolo nosso:</b> Não<br/>';
	}else{
		$textmail .= '<b>Fez a selecção através de um bolo nosso:</b> Sim<br/>';
		$bolonosso = boloGetById($row['pp_enc_idbolonosso']);
		//mail
		$textmail .= '<img height="150" width="250" src="'.$bolonosso['pp_bolo_urlimage'].'"/><br/>';
	}
	
	$textmail .= '<h4 style="color:green">Composição:</h4>';
	if($row['pp_enc_coberturaid'] == '')
	{
		$textmail .= '<b>Cobertura:</b> '.$row['pp_enc_coberturaoutra'].'<br/>';
	}else{
		$data_cob = coberturaGetById($row['pp_enc_coberturaid']);
		$textmail .= '<b>Cobertura:</b> '.$data_cob['pp_cobertura_designacao'].'<br/>';
	}
	if($row['pp_enc_recheioid'] == '')
	{
		$textmail .= '<b>Recheio:</b> '.$row['pp_enc_recheiooutra'].'<br/>';
	}else{
		$data_cob = recheioGetById($row['pp_enc_recheioid']);
		$textmail .= '<b>Recheio:</b> '.$data_cob['pp_recheio_designacao'].'<br/>';
	}
	if($row['pp_enc_massaid'] == '')
	{
		$textmail .= '<b>Massa:</b> '.$row['pp_enc_massaoutra'].'<br/>';
	}else{
		$data_cob = massaGetById($row['pp_enc_massaid']);
		$textmail .= '<b>Massa:</b> '.$data_cob['pp_massa_designacao'].'<br/>';
	}
	
	$textmail .= '<h4 style="color:green">Outros:</h4>';
	if($row['pp_enc_peso'] != '')
	{
		$textmail .= '<b>Peso:</b> '.$row['pp_enc_peso'].' Kg <br/>';
	}
	if($row['pp_enc_pessoas'] != '')
	{
		$textmail .= '<b>Pessoas:</b> '.$row['pp_enc_pessoas'].'<br/>';
	}
	if($row['pp_enc_dizeres'] != '')
	{
		$textmail .= '<b>Dizeres:</b> '.$row['pp_enc_dizeres'].'<br/>';
	}
	if($row['pp_enc_obs'] != '')
	{
		$textmail .= '<b>Observações:</b> '.$row['pp_enc_obs'].'<br/>';
	}	
}

$textmail .= '</body></html>';

//echo $textmail;
?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
    		<form name="changegr" class="form-horizontal" onsubmit="return false;" >
        		<fieldset>

            		<!-- Form Name -->
            			<legend>Visualização das encomendas diarias</legend>
            			<?php
            			if (strpos($textmail,'Encomenda') !== false) 
            			{
    					echo $textmail;
				}else{
					echo 'Não existe encomendas para hoje e os proximos 8 dias';
				}
            			?>
            
        		</fieldset>
    		</form>    
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->




<?php include 'includes/footer.php';?>