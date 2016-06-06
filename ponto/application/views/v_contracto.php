<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('level') == 2)
{
	$this->load->view('template/header_admin');
	$this->load->view('template/footer_admin');
}else{
	$this->load->view('template/header_user');
	$this->load->view('template/footer_user');
}
?>

<div class="col-md-10 col-md-offset-1">
	<legend>Horas do Contrato</legend>
</div>


<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-5 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
<?php } ?>

<div class="row top10">
	<?php
	if(isset($informacao) && $informacao != "")
	{?>
		<!-- sem resultados -->
		<div class="col-md-10 col-md-offset-1">	
			<div class="col-md-4 col-md-offset-4">
				<?= $informacao;?>	
			</div>
		</div>
		<?php
	}else{
		if(isset($result))
		{
			?>
			<!--Resultados-->
			<div class="col-md-4 col-md-offset-4 table-responsive">
				<table class="table table-hover contractos display" id="holiday">
					<thead>
				      		<tr>
				        		<th data-sort="int">Nº</th>
				        		<th>Nome</th>
				        		<th>Contrato</th>
				        		<th>Editar</th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					$i = 1;
					foreach($result as $row)
					{?>
						<tr class="<?= 'tr'.$i;?>">
							<td><?= $row['Userid'];?></td>
							<td id="<?= 'name'.$i;?>"><?= $row['Name'];?></td>
							<td id="<?= 'td'.$i;?>"><?= $row['Contracto'];?></td>
							<td onclick="editContracto(<?= $row['Userid'];?>,<?= $i;?>)"><img src="<?= base_url('images/edit.png');?>" height="20px" width="20px" ></td>
						</tr>
						<?php
						$i++;
					}?>
					</tbody>
				</table>
				<!--<div class="top20">
					*Inserir um contracto de 40h assim: 40, 20horas: 20,....
				</div>-->				
			</div>
			<?php
		}
	}?>
</div>

<script>
function editContracto(userid,ciclo)
{
	var newtd = '#td'+ciclo;
	var newtdname = '#name'+ciclo;
	var contracto = $.trim($(newtd).html());
	var nameold = $.trim($(newtdname).html());
	
	/*$('#antigapicagem').val(horaold);
	$('#logid').val(logid);
	$('#novapicagem').val('');	
	$('#modalChangePicagem').modal({
		keyboard: true	
	});*/	
	
	Lobibox.prompt('number',{
	    	title: 'Nome: '+nameold,
	    	buttonsAlign: 'right',
	    	draggable: true,
	    	value: contracto,
	    	buttons: {
		        ok: {
		            	closeOnClick: true,
            			text: 'Inserir'
		        },
		        cancel: {
		            	closeOnClick: true,
            			text: 'Cancelar'
		        }
		},	
	    	callback: function ($this, type, ev) {
		        if(type == 'ok')
		        {
		        	var contractonew = $this.getValue();
		        	
		        	var values = {Userid: userid, Contracto: contractonew};
				var newform = createform('<?= base_url("home/editar_contracto");?>',values);
				$.ajax({
				        url: '<?= base_url("home/editar_contracto");?>',
				        type: 'post',
				        dataType: 'json',
				        data: $(newform).serializeArray(),
				        success: function(data) {
				        		if(data.return == 'success')
				  			{
								noty({ 
							    		text: data.message,
							    		type: "success",
							    		layout: "center",
							    		closeWith: ['click', 'hover']
							    	});
							    	//ordenar de novo a tabela
							    	tabledatatable.destroy();
							    	$(newtd).html(contractonew);
							    	//$(newtdname).html(namenew);
							    	//ordenar de novo a tabela
							    	startDatatableCon();
							}else{
								noty({ 
							    		text: data.message,
							    		type: "error",
							    		layout: "center",
							    		closeWith: ['click', 'hover']
							    	});
							}
				                },
				        error: function(xhr, textStatus, errorThrown) {
				        		alert("Erro no envio do pedido por ajax: "+xhr.responseText); 
				        	}
			    	});
			}
		}
	});
}
startDatatableCon();
</script>