<?php include 'includes/header.php'; ?>
    
    <script>
    	function alterarCob(id, cobertura)
    	{
		var my_text=prompt('Vai alterar essa cobertura: '+cobertura);
		var continu = true;
		if(my_text == '')
		{
			//alert(my_text+'va');	
			continu = false;
		}
		if(my_text == 'undefined')
		{
			//alert(my_text+'UN');	
			continu = false;
		}
		if(my_text == null)
		{
			//alert(my_text+'null');	
			continu = false;
		}
		if(continu)
		{
			alterarComposicao(my_text,id,'cob');	
		}		
	}
	function alterarRec(id, cobertura)
    	{
		var my_text=prompt('Vai alterar essa cobertura: '+cobertura);
		var continu = true;
		if(my_text == '')
		{
			//alert(my_text+'va');	
			continu = false;
		}
		if(my_text == 'undefined')
		{
			//alert(my_text+'UN');	
			continu = false;
		}
		if(my_text == null)
		{
			//alert(my_text+'null');	
			continu = false;
		}
		if(continu)
		{
			alterarComposicao(my_text,id,'rec');	
		}		
	}
	function alterarMas(id, cobertura)
    	{
		var my_text=prompt('Vai alterar essa cobertura: '+cobertura);
		var continu = true;
		if(my_text == '')
		{
			//alert(my_text+'va');	
			continu = false;
		}
		if(my_text == 'undefined')
		{
			//alert(my_text+'UN');	
			continu = false;
		}
		if(my_text == null)
		{
			//alert(my_text+'null');	
			continu = false;
		}
		if(continu)
		{
			alterarComposicao(my_text,id,'mas');	
		}		
	}
	//tipo:
	//cob: cobertura
	//rec: recheio
	//mas: massa
	function alterarComposicao(newtext,id,tipo)
	{
		$.get( "ajax/ajmodif_comp.php", { 
			id: id,
			newtext: newtext,
			tipo: tipo}, 'text' )
			.done(function( data ) {
		   	    var newdata = data.trim();
			    if(newdata == "ok")
			    {
			    	alert('Composição alterada');
			    	window.location = "view_composicao.php";			    	
			    }else{
			    	alert(newdata);
			    }
		});		
	}    	
    </script>
    
    
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

			
                    <!-- Form Name -->
                    <legend><a id="tablecoberturas" onclick="toggleTable(true);" href="#">Coberturas</a></legend>
                        
                        <table id="mytable_cob" class="table table-bordered display" cellspacing="0" width="">
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
		                					<td><?= $data['pp_cobertura_designacao'];?></td>
		                					<td><img onclick="alterarCob('<?= $data['pp_cobertura_id'];?>','<?= $data['pp_cobertura_designacao'];?>')" height="20" width="20" src="images/alterar.jpg"/></td>
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
                    
                    <legend><a id="tablerecheio" onclick="toggleTable(true);" href="#">Recheio</a></legend>
                        
                        <table id="mytable_rec" class="table table-bordered display" cellspacing="0" width="">
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
		                					<td><?= $data['pp_recheio_designacao'];?></td>
		                					<td><img onclick="alterarRec('<?= $data['pp_recheio_id'];?>','<?= $data['pp_recheio_designacao'];?>')" height="20" width="20" src="images/alterar.jpg"/></td>
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
			
		      <legend><a id="tablemassa" onclick="toggleTable(true);" href="#">Massa</a></legend>
                        
                        <table id="mytable_mas" class="table table-bordered display" cellspacing="0" width="">
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
		                					<td><?= $data['pp_massa_designacao'];?></td>
		                					<td><img onclick="alterarMas('<?= $data['pp_massa_id'];?>','<?= $data['pp_massa_designacao'];?>')" height="20" width="20" src="images/alterar.jpg"/></td>
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
    
    <script>
    $(document).ready(function() {
    	$('#mytable_cob').toggle('slow');
    	$('#mytable_rec').toggle('slow');
    	$('#mytable_mas').toggle('slow');
    		$('#tablecoberturas').click(function() {
    		$('#mytable_cob').toggle('slow');
    	});
    		$('#tablerecheio').click(function() {
    		$('#mytable_rec').toggle('slow');
    	});
    		$('#tablemassa').click(function() {
    		$('#mytable_mas').toggle('slow');
    	});
    })
    
    </script>
    
<?php include 'includes/footer.php';?>