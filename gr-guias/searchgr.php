<?php include 'includes/header.php'; ?>
    
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Procurar Guia</legend>
                    
                    <?php
                    if($_SESSION['archive_gr'] == '')
                    {
		    	$where = "id > 0 AND gr_enable = 1";	
		    }else{
		    	$date_menos = date("Y-m-d", strtotime($date_atual . ' - '.$_SESSION['archive_gr'].' days'));
		    	$where = "id > 0 AND gr_enable = 1 AND (date_tocliente >= ".dbString($date_menos)." || date_tocliente IS NULL)";
		    	//echo $where;
		    }
                    
		    $order = " DESC";
		    $table = grepGetByFiltro($where, "date_in".$order);
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
			            <th>Data Entrada</th>  
			            <th>Data Reparador</th>
			            <th>Data SMS</th>
			            <th>Entregue?</th>
			            <th>Data Levantamento</th>
			            <th>Tipo</th>
			            <th>Marca</th>
			          </tr>  
			    </thead>
			    <tbody> 
			    <?php
			    
			        while($data = mysql_fetch_array($table))
			        {
			            ?>
			            <tr onclick="viewGr('<?= $data['id'];?>');">  
			                <td><?= $data['id'];?></td>  
			                <td><?= $data['cl_name'];?></td>
			                <td><?= $data['cl_telefone'];?></td>
			                <td><?= $data['date_in'];?></td>
			                <td><?= $data['date_torep'];?></td>
			                <td><?= $data['date_sms'];?></td>
			                <td>
			                	<?php
			                	switch($data['status_sms']){
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
			                <td><?= $data['date_tocliente'];?></td>                
			                <td><?= $data['art_type'];?></td>
			                <td><?= $data['art_marca'];?></td>
			            </tr>
			            <?php
			        }        
			    }else{?>
				<table id="" class="table table-striped table-bordered display" cellspacing="0" width="auto">
			    <thead>  
			          <tr>  
			            <th>Nº</th>  
			            <th>Nome</th> 
			            <th>Contacto</th> 
			            <th>Data Entrada</th>  
			            <th>Data Reparador</th>
			            <th>Data SMS</th>
			            <th>Entregue?</th>
			            <th>Data Levantamento</th>
			            <th>Tipo</th>
			            <th>Marca</th>
			          </tr>  
			    </thead>
			    <tbody> 
			        <tr>
			            <td colspan="10" style="text-align: center;">Não há resultados</td> 
			        </tr>    
			        <?php
			    }
			    }
			    ?>  
			    </tbody>
			</table>
			E = Entregue, P = Pendente, N = Não entregue, NP = Não Processada
                    
                    <!--<div class="form-group">
                        <div class="col-sm-3 col-md-offset-2">
                            <select id="cbsearchgr" class="form-control" onchange="hiddenButtonss(this)">
                                <option></option>
                                <option value="id">Numero da Guia</option>
                                <option value="cl_name">Nome Cliente</option>
                                <option value="cl_telefone">Contacto do cliente</option>
                                <option value="status_sms">Estado SMS</option>
                                <option value="art_type">Tipo</option>
                                <option value="art_marca">Marca</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) searchGr()" />
                        </div>
                        <div class="col-sm-4">
                            <input type="button" onclick="searchGr()" class="btn btn-primary" value="Procurar" >
                            <input type="hidden" onclick="searchAllGr()" class="btn btn-primary" value="Ver Todas" id="allsearch">
                        </div>                        
                    </div>
                    
                    <div name="requestajviewgr" id="requestajviewgr">
                    	                         
                    </div>-->
                    
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
            	"scrollY": "400px",
        	"scrollCollapse": true,
        	"paging": true,
        	"scrollX": true 
    	});
    } );
    </script>
    
    
    <!-- exemplo para o autcomplete
    
    <script>
	$('#valorsearch').autocomplete({
		source : function( request, response ) {
			var type_search = $('#cbsearchgr').val();
			if($('#cbsearchgr').val() != 'status_sms' || $('#cbsearchgr').val() != 'id'){
				
					
			$.ajax({
				url : 'ajax/ajac.php',
		      		dataType: "json",
				data: {
			   		write_search: request.term,
			   		type: type_search
				},
				success: function( data ) {
				response( $.map( data, function( item ) {
					return {
						label: item,
						value: item
					}
				}));
			}
		      });}
	},
	minLength : 0,
	autoFocus : true,

});
     </script>-->
    
<?php include 'includes/footer.php';?>