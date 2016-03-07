<?php include 'includes/header.php'; ?>
    
    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <form name="changegr" class="form-horizontal" >
                <fieldset>

			
                    <!-- Form Name -->
                    <legend>Coberturas <a id="tablecoberturas" onclick="toggleTable(true);" href="#"><img /></a></legend>
                        
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
    		$('#tablecoberturas').click(function() {
    		$('#mytable_cob').toggle('slow');
    	});
    })
    
    </script>
    
<?php include 'includes/footer.php';?>