<?php include 'includes/header.php'; ?>
    
    <script>
    	function viewEncomenda(id)
    	{
		window.location = "view_encbolo.php?pp_enc_id="+id;	
	}    	
    </script>
    
    
    
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Procurar Encomenda</legend>
                    
                    <?php
                    $where = "pp_enc_enable = 1";
		    $order = " DESC";
		    $table = encomendasGetByFiltro($where, "pp_enc_datedone".$order);
		    if (is_bool($table) === false) 
		    {
		    	if (mysql_num_rows($table) > 0)
			{
                    ?>

			<!-- <table id="example" class="table table-striped table-hover"> -->
			<table id="mytable" class="table table-striped table-bordered display" cellspacing="0" width="auto">
			    <thead>  
			          <tr>  
			            <th>Nº</th>  
			            <th>Nome</th> 
			            <th>Contacto</th> 
			            <th>Data Criação</th>  
			            <th>Data Levantamento</th>
			            <th>Data SMS</th>
			            <th>Sms Entregue?</th>
			            <th>Cliente Levantou</th>			            
			          </tr>  
			    </thead>
			    <tbody> 
			    <?php
			    
			    
			    
			        while($data = mysql_fetch_array($table))
			        {
			            ?>
			            <tr onclick="viewEncomenda('<?= $data['pp_enc_id'];?>');">  
			                <td><?= $data['pp_enc_id'];?></td>  
			                <td><?= $data['pp_enc_clientname'];?></td>
			                <td><?= $data['pp_enc_clientcontact'];?></td>
			                <td><?= $data['pp_enc_dateenc'];?></td>
			                <td><?= $data['pp_enc_datedone'];?></td>
			                <td><?= $data['pp_enc_datesms'];?></td>
			                <td>
			                	<?php
			                	switch($data['pp_enc_statussms']){
							case 1:
								echo "E";
								break;
							case 2:
								echo "P";
								break;
							case 3:
								echo "N";
								break;
							case 0:
								echo "NP";
								break;
							default:
								break;
						}?>
			                	
			                </td>
			                <td><?= $data['pp_enc_datalevantamento'];?></td>                
			                
			            </tr>
			            <?php
			        }?>
			        </tbody>
			</table>        
				<?php
				
			    }else{?>
			        <table class="table table-striped table-bordered display" cellspacing="0" width="auto">
				    <thead>  
				          <tr>  
				            <th>Nº</th>  
				            <th>Nome</th> 
				            <th>Contacto</th> 
				            <th>Data Criação</th>  
				            <th>Data Levantamento</th>
				            <th>Data SMS</th>
				            <th>Sms Entregue?</th>
				            <th>Cliente Levantou</th>			            
				          </tr>  
				    </thead>
				    <tbody> 
			        <tr>
			            <td colspan="10" style="text-align: center;">Não há resultados</td> 
			        </tr>    
			        <?php
			    
			    
			    ?>  
			    </tbody>
			</table>
			<?php
				}
			}			
			?>
			E = Entregue, P = Pendente, N = Não entregue, NP = Não Processada			
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    $(document).ready(function() {
    	$('#mytable').DataTable({
    		"language": {
            		"lengthMenu": "Ver _MENU_ linhas por paginas",
            		"zeroRecords": "Não foi encontrado nada",
            		"info": "Pagina _PAGE_ de _PAGES_",
            		"infoEmpty": "Não há guias inseridas",
            		"infoFiltered": "(Filtro de _MAX_ linhas)",
            		"sSearch": "Procurar:",	
            		"oPaginate": {
				"sFirst":    "Primeira",
				"sLast":     "Ultima",
				"sNext":     "Proxima",
				"sPrevious": "Anterior"
			}
            	},
            	"scrollY": "420px",
        	"scrollCollapse": true,
        	"paging": true,
        	"scrollX": false,
        	"order": [[4, "desc"]] 
    	});
    } );
    </script>
    
    
<?php include 'includes/footer.php';?>