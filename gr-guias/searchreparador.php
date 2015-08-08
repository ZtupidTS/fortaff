<?php include 'includes/header.php'; ?>
    
    	<script>
    	function viewReparador(id)
	{
	   window.location = "viewreparador.php?id="+id;
	   //$().redirect('viewgr.php', {'id': +id});    
	}
	/*function searchReparador()
	{
	    var e = document.getElementById('cbsearchgr');
	    var strSearch = e.options[e.selectedIndex].value;
	    if(strSearch == '')
	    {
	        alert('Tem de seleccionar uma escolha');
	    }else{
	        var valor = document.getElementById("valorsearch").value;
	        if(valor == "")
	        {
	            alert( "Tem de preencher o campo da procura" );
	            document.getElementById("valorsearch").focus() ;            
	        }else{
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
	                    //aqui preencho o meu div com o conteúdo do pedido ajax
	                    document.getElementById("requestajviewgr").innerHTML=xhr.responseText;                    
	                }
	            }
	            xhr.open("POST","ajax/ajsearchreparador.php",true);
	            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	            xhr.send('campo='+strSearch+'&valor='+valor);
	        }                
	    }
	}*/
   	 </script>
    
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualizar Reparador</legend>
                    
                    
                    	<?php
			$where = " rep_enable = 1 AND rep_enable = 1";

			$table = reparadorGetByFiltro($where, "rep_id");
			?>
			<table id="mytable" class="table table-striped table-bordered display" cellspacing="0" width="auto">
			    <thead>  
			          <tr>  
			            <th>Nº</th>  
			            <th>Nome</th> 
			            <th>Email</th> 
			            <th>Email2</th>
			            <th>Contacto</th>
			            <th>Nome</th>
			            <th>Contacto 2</th>
			            <th>Nome 2</th>
			          </tr>  
			    </thead>
			    <tbody> 
			    <?php
			    if (mysql_num_rows($table) > 0)
			    {
			        while($data = mysql_fetch_array($table))
			        {
			            ?>
			            <tr onclick="viewReparador('<?= $data['rep_id'];?>');">  
			                <td><?= $data['rep_id'];?></td>  
			                <td><?= $data['rep_name'];?></td>
			                <td><?= $data['rep_email'];?></td>
			                <td><?= $data['rep_email2'];?></td>
			                <td><?= $data['rep_telefone1'];?></td>
			                <td><?= $data['rep_nome1'];?></td>
			                <td><?= $data['rep_telefone2'];?></td>                
			                <td><?= $data['rep_nome2'];?></td>
			            </tr>
			            <?php
			        }        
			    }else{?>
			        <tr>
			            <td colspan="8" style="text-align: center;">Não há resultados</td> 
			        </tr>    
			        <?php
			    }
			    ?>  
			    </tbody>
			</table>
                    
                    <!--<div class="form-group">
                        <div class="col-sm-3 col-md-offset-2">
                            <select id="cbsearchgr" class="form-control">
                                <option></option>
                                <option value="rep_id">Numero do Reparador</option>
                                <option value="rep_name">Nome do Reparador</option>
                                <option value="rep_telefone">Contacto do Reparador</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="valorsearch" id="valorsearch" class="form-control" onkeyup="if(event.keyCode == 13) searchReparador()"/>
                        </div>
                        <div class="col-sm-4">
                            <input type="button" onclick="searchReparador()" class="btn btn-primary" value="Procurar">
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
    
    
    
    
<?php include 'includes/footer.php';?>