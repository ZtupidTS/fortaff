<?php include 'includes/header.php'; ?>
    
    <script>
    function modificarComposicao(id,tipo,alterar)
    {
        //0: cobertura
        //1: recheio
        //2: massa
        
        
	$.get( "ajax/ajmodif_composicao.php", { 
		id: id,
		tipo: tipo,
		alterar: alterar}, 'text' )
		.done(function( data ) {
	   	    var newdata = data.trim();
		    if(newdata == "ok")
		    {
		    	if(ativar == '1')
		    	{
				alert('Composicao de novo disponivel para encomendas');	
			}else{
				alert('Composicao indisponivel para encomendas');
			}			    	
		    	window.location = "modif_composicao.php";
		    }else{
		    	//$('#suppliertype').hide();
		    	alert(newdata);
		    }
	});

	
	
    }
    </script>



    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

			Perguntar pelo facto de se desativo aqui uma composição, quando crio uma encomenda a partir de um bolo nosso vai aparecer em branco a seleção.
			E já não aparece na criação ds bolos.
                    <!-- Form Name -->
                    <legend>Coberturas</legend>
                        
                        <table id="mytable" class="table table-bordered display" cellspacing="0" width="">
	    			<tbody> 
	    				<?php
	    				$table = coberturaGetAll();
	    				if (is_bool($table) === false) 
	    				{
	    	    				if (mysql_num_rows($table) > 0)
		    				{
		        				while($data = mysql_fetch_array($table))
		        				{?>
		            					<tr>
		                					<td width="295"><?= $data['pp_cobertura_designacao'];?></td>  
		                					<td width="40" class="text-center" style="vertical-align: middle;">
		                						<?php
		                						if($data['pp_cobertura_enable'] == '1')
		                						{?>
											<img onclick="modificarComposicao(<?= $data['pp_cobertura_id'];?>,0,0)" height="20" width="20" src="images/eliminar.jpg"/>
											<?php	
										}else{?>
											<img onclick="modificarComposicao(<?= $data['pp_cobertura_id'];?>,0,1)" height="20" width="20" src="images/validar.jpg"/>
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
                    
                    <legend>Recheio</legend>
                        
                        <table id="mytable" class="table table-bordered display" cellspacing="0" width="">
	    			<tbody> 
	    				<?php
	    				$table = recheioGetAll();
	    				if (is_bool($table) === false) 
	    				{
	    	    				if (mysql_num_rows($table) > 0)
		    				{
		        				while($data = mysql_fetch_array($table))
		        				{?>
		            					<tr>
		                					<td width="295"><?= $data['pp_recheio_designacao'];?></td>  
		                					<td width="40" class="text-center" style="vertical-align: middle;">
		                						<?php
		                						if($data['pp_recheio_enable'] == '1')
		                						{?>
											<img onclick="modificarComposicao(<?= $data['pp_recheio_id'];?>,1,0)" height="20" width="20" src="images/eliminar.jpg"/>
											<?php	
										}else{?>
											<img onclick="modificarComposicao(<?= $data['pp_recheio_id'];?>,1,1)" height="20" width="20" src="images/validar.jpg"/>
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
			
		      <legend>Massa</legend>
                        
                        <table id="mytable" class="table table-bordered display" cellspacing="0" width="">
	    			<tbody> 
	    				<?php
	    				$table = massaGetAll();
	    				if (is_bool($table) === false) 
	    				{
	    	    				if (mysql_num_rows($table) > 0)
		    				{
		        				while($data = mysql_fetch_array($table))
		        				{?>
		            					<tr>
		                					<td width="295"><?= $data['pp_massa_designacao'];?></td>  
		                					<td width="40" class="text-center" style="vertical-align: middle;">
		                						<?php
		                						if($data['pp_massa_enable'] == '1')
		                						{?>
											<img onclick="modificarComposicao(<?= $data['pp_massa_id'];?>,2,0)" height="20" width="20" src="images/eliminar.jpg"/>
											<?php	
										}else{?>
											<img onclick="modificarComposicao(<?= $data['pp_massa_id'];?>,2,1)" height="20" width="20" src="images/validar.jpg"/>
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
                    
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
<?php include 'includes/footer.php';?>