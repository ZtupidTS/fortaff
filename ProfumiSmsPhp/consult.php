<?php include 'includes/header.php'; ?>
    
    <!--<script>
    	function searchGr()
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
	            xhr.open("POST","ajax/ajsearchgr.php",true);
	            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	            xhr.send('campo='+strSearch+'&valor='+valor);
	        }                
	    }
	}
    </script>-->
    
    
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <form name="changegr" class="form-horizontal" onsubmit="return false;">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Visualizar Sms Enviados</legend>
                    
	               	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>ID</th>
			                <th>Estado</th>
			                <th>SMS ID</th>
			                <th>Nome</th>
			                <th>Sms Data</th>
			                <th>Sms Hora</th>
			                <th>Sms Contacto</th>
			                <th>Sms Texto</th>
			            </tr>
			        </thead>
			        <!--<tfoot>
			            <tr>
			                <th>ID</th>
			                <th>Result</th>
			                <th>SMS ID</th>
			                <th>Sms Inserted</th>
			                <th>Nome</th>
			                <th>Sms State</th>
			                <th>Sms Date</th>
			                <th>Sms Contact</th>
			                <th>Sms Text</th>
			            </tr>
			        </tfoot>-->
			        <tbody>
			          
			           <?php
			            $table = smsGetByFiltro("", "sms_date");
			            
			            if (count($table) > 0)
    				    {
    				    	while($data = $table->fetchArray())
        				{?>
			            
				            <tr onclick="viewGr('<?= $data['id'];?>');">
				                <td><?= $data['id'];?></td>
				                <td><?php
				                switch ($data['state']) {
						    case "OK":
						        echo "Entregue";
						        break;
						    case "2":
						        echo "Enviado e Pendente";
						        break;
						    case "3":
						        echo "Não Entregue";
						        break;
						    case "0":
						        echo "Não Processado";
						        break;
						}
				                ?></td>
				                <td><?= $data['smsid'];?></td>
				                <td><?= $data['user_name'];?></td>
				                <?php
				                $new_date = splitDateTime($data['sms_date']);
				                ?>
				                <td><?= inverte_data($new_date[0]);?></td>			                
				                <td><?= $new_date[1];?></td>				                
				                <td><?= $data['sms_contact'];?></td>				                
				                <td><?= $data['sms_text'];?></td>				                
				            </tr>
			            	<?php
			            	}
			            }?>
			        </tbody>
			    </table>
                    
                    <div name="requestajviewgr" id="requestajviewgr">
                    	                         
                    </div>
                    
                </fieldset>
            </form>
            
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
    
    <script>
    $(document).ready(function() {
	    $('#example').dataTable();
	} );
    </script>
    
<?php include 'includes/footer.php';?>