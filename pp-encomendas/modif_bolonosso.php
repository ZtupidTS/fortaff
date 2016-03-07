<?php include 'includes/header.php'; ?>

	<script>
	function alterarBolo(id, ativar)
	{
		$.get( "ajax/ajmodif_bolo.php", { 
			id: id,
			ativar: ativar}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	if(ativar == '1')
			    	{
					alert('Bolo de novo disponivel para encomendas');	
				}else{
					alert('Bolo indisponivel para encomendas');
				}			    	
			    	window.location = "modif_bolonosso.php";			    	
			    }else{
			    	//$('#suppliertype').hide();
			    	alert(newdata);
			    }
		});
		
	}
	function modificarbolo()
	{
		alert('Ainda não implementado');
	}
	</script>
	
	<?php
	$table = viewBoloGetAll();
	?>
	
	<table id="mytable" class="table table-bordered display" cellspacing="0" width="">
	    <!--<thead>  
	          <tr>  
	            <th>Nº</th>  
	            <th>Nome</th> 
	            <th>Contacto</th> 
	            <th>Data Entrada</th>  
	            <th>Data Reparador</th>
	            <th>Data SMS</th>
	            <th>Entregue?</th>
	            <th>Data Levantamento</th>
	          </tr>  
	    </thead>-->
	    <tbody> 
	    <?php
	    if (is_bool($table) === false) 
	    {
	    	    if (mysql_num_rows($table) > 0)
		    {
		        while($data = mysql_fetch_array($table))
		        {
		            ?>
		            <tr class="text-center">  
		            	<td colspan="3" bgcolor="#535455" ><font color="#ffffff"><?= $data['pp_bolo_nome'];?></font></td>  
		            </tr>
		            <tr>
		                <td rowspan="3" width="255"><img height="150" width="250" src="<?= $data['pp_bolo_urlimage'];?>"/></td>  
		                <td>
		                	<b>Cobertura:</b><br/>
		                	<?= $data['pp_cobertura_designacao'];?>
		                </td>
		                <td class="text-center" style="vertical-align: middle;">
		                	<img onclick="modificarbolo()" height="20" width="20" src="images/alterar.jpg"/>
		                </td>
		            </tr>
		            <tr> 
		                <td>
		                	<b>Recheio:</b><br/>
		                	<?= $data['pp_recheio_designacao'];?>		                	
		                </td>
		                <td class="text-center" style="vertical-align: middle;"  >
		                	<?php
		                	if($data['pp_bolo_enable'] == '1')
		                	{
		                		?>
						<img onclick="alterarBolo(<?= $data['pp_bolo_id'];?>,0)" height="20" width="20" src="images/eliminar.jpg"/>
						<!--<input type="image" src="images/eliminar.jpg" onclick="alterarBolo(<?= $data['pp_bolo_id'];?>,0)">-->
						<!--<input type="button" onclick="alterarBolo()" src="images/eliminar.jpg">-->
						<?php
					}?>		                	
		                </td>
		            </tr>
		            <tr>
		                <td>
		                	<b>Massa:</b><br/>
		                	<?= $data['pp_massa_designacao'];?>		                	
		                </td>
		                <td class="text-center" style="vertical-align: middle;">
		                	<?php
		                	if($data['pp_bolo_enable'] == '0')
		                	{
		                		?>
						<img onclick="alterarBolo(<?= $data['pp_bolo_id'];?>,1)" height="20" width="20" src="images/validar.jpg"/>
						<!--<input type="image" src="images/validar.jpg" onclick="alterarBolo(<?= $data['pp_bolo_id'];?>,1)">-->
						<?php
					}?>
		                </td>
		            </tr>
		            <?php
	        	}        
		    }else{?>
		        <tr>
		            <td colspan="2" style="text-align: center;">Não há resultados</td> 
		        </tr>    
		        <?php
		    }
	    }
	    ?>  
	    </tbody>
	</table>
	
	<script>
	$('img[onclick]').click(function(e) {e.preventDefault();});
	</script>

<?php include 'includes/footer.php';?>