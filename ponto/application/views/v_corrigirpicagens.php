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
	<legend>Corrigir Picagens</legend>
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
			<div class="col-md-3 col-md-offset-4 table-responsive">
				<table class="table table-hover picagens display" id="picagens">
					<caption>
						<!-- Form para voltar a pagina das picagens -->
						<form hidden id="formback" class="form-inline" role="form" method="post" action="<?= base_url('home/verify_picagens');?>">
							<input type="text" id="datefirst" value="<?= $datefirst;?>" class="form-control" required name="datefirst">	
							<input type="text" id="datesecond" value="<?= $datesecond;?>" class="form-control" required name="datesecond">							
						</form>
						<button type="button" id="btn_back" class="btn btn-default" onclick="submitformback()">Voltar</button>
						<div class="top7">
							<?php 
							$newdate = date_create($datapicagem);
							echo $nomeuser.' Do Dia '.date_format($newdate,'d-m-Y');
							?>
						</div>	
					</caption>
					<thead>
				      		<tr>
				        		<th data-sort="int">Logid</th>
				        		<th>CheckTime</th>
				        		<th>Editar</th>
				        		<th>Eliminar</th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					$i = 1;
					foreach($result as $row)
					{?>
						<tr class="<?= 'td'.$i;?>">
							<td><?= $row['Logid'];?></td>
							<td id="<?= 'td'.$i;?>">
								<?php
								$newdate = date_create($row['CheckTime']);
								echo date_format($newdate,'H:i:s');
								?>	
							</td>
							<td onclick="editpicagem(<?= $row['Logid'];?>,'<?= 'td'.$i;?>')"><img src="<?= base_url('images/edit.png');?>" height="20px" width="20px" ></td>
							<td onclick="delpicagem(<?= $row['Logid'];?>,'<?= 'td'.$i;?>')"><img src="<?= base_url('images/remove.png');?>" height="20px" width="20px" ></td>
						</tr>
						<?php
						$i++;
					}?>
					</tbody>
				</table>
				<div>
					<button type="button" class="btn btn-default pull-right" onclick="addPicagem()">Adicionar Picagem</button>
				</div>
			</div>
			<?php
		}
	}?>
</div>

<!-- Form modal -->
<div class="modal fade" id="modalChangePicagem" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
				<h4 class="modal-title">Editar Picagem</h4>
			</div>
			<form id="formmodal" name="formmodal" role="form" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label for="antigapicagem" class="control-label">Antiga Picagem:</label>
						<input type="text" size="30" class="form-control" name="antigapicagem" id="antigapicagem" readonly>
					</div>
					<div class="form-group">
						<label for="novapicagem" class="control-label">Nova Picagem:</label>
						<input type="time" step="1" size="30" class="form-control" name="novapicagem" id="novapicagem">
					</div>
					<!-- aqui a parte do form escondido -->
					<div class="form-group" hidden>
						<input type="text" class="form-control" name="logid" id="logid">
						<input type="text" class="form-control" name="datapicagem" id="datapicagem" value="<?= $datapicagem;?>">
						<input type="text" class="form-control" name="iduser" id="iduser" value="<?= $iduser;?>">
						<input type="text" class="form-control" name="datefirst" id="datefirst" value="<?= $datefirst;?>">
						<input type="text" class="form-control" name="datesecond" id="datesecond" value="<?= $datesecond;?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="modalclose" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" >Save changes</button>
				</div>
			</form>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script>
//var datapicagem = '<?= $datapicagem;?>';
var newtd = '';
function editpicagem(logid,td)
{
	newtd = '#'+td;
	var horaold = $.trim($(newtd).html());
	$('#antigapicagem').val(horaold);
	$('#logid').val(logid);
	$('#novapicagem').val('');	
	$('#modalChangePicagem').modal({
		keyboard: true	
	});	
}
function delpicagem(logid,td)
{
	newtd = '#'+td;
	newtr = '.' +td;
	$('#logid').val(logid);
	
    	Lobibox.confirm({
	    	msg: "Pretende eliminar essa picagem? (não se pode voltar atrás)",
	    	buttonsAlign: 'right',
	    	title: 'Pergunta',
	    	buttons: {
		        yes: {
		            'class': 'lobibox-btn lobibox-btn-yes',
		            text: 'Sim',
		            closeOnClick: true
		        },
		        no: {
		            'class': 'lobibox-btn lobibox-btn-no',
		            text: 'Não',
		            closeOnClick: true
		        }
		},
	    	callback: function ($this, type, ev) {
		        if(type == 'yes')
		        {
				$.ajax({
				        url: '<?= base_url("home/del_picagem");?>',
				        type: 'post',
				        dataType: 'json',
				        data: $('#formmodal').serializeArray(),
				        success: function(data) {
				        		//console.log(data);
				  			if(data.return == 'success')
				  			{
								noty({ 
							    		text: data.message,
							    		type: "success",
							    		layout: "center",
							    		closeWith: ['click', 'hover']
							    	});
							    	//hide this tr
							    	$(newtr).hide();	
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
	return false;
}
$('#formmodal').submit(function() {
	var novapica = $('#novapicagem').val();
	$.ajax({
	        url: '<?= base_url("home/editar_picagem");?>',
	        type: 'post',
	        dataType: 'json',
	        data: $('#formmodal').serializeArray(),
	        success: function(data) {
	        		//console.log(data);
	        		if(data.return == 'success')
	  			{
					noty({ 
				    		text: data.message,
				    		type: "success",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});
					$(newtd).html(novapica+':00');
	  				$('#modalclose').click();	
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
    	return false;
}); 

function submitformback()
{
	$('#formback').submit();
}

function addPicagem()
{
	Lobibox.prompt('time',{
	    	title: 'Hora da picagem a inserir:',
	    	buttonsAlign: 'right',
	    	draggable: true,
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
		attrs: {
       			placeholder: "__:__:__",
    		},	
	    	callback: function ($this, type, ev) {
		        if(type == 'ok')
		        {
		        	var regex = new RegExp("(([0-1][0-9])|([2][0-3])):([0-5][0-9])");
		        	var newpicagem = $this.getValue()+':00';
		        	if (regex.test(newpicagem) && newpicagem.length < 9) 
		        	{
		        		$('#novapicagem').val(newpicagem);
		        		$.ajax({
					        url: '<?= base_url("home/add_picagem");?>',
					        type: 'post',
					        dataType: 'json',
					        data: $('#formmodal').serializeArray(),
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
								    	var rowCount = $('.picagens tr').length;
								    	$('.picagens').last().append('<tr class="td'+rowCount+'"><td>'+data.Logid+'</td><td id="td'+rowCount+'">'+newpicagem+'</td><td onclick="editpicagem('+data.Logid+',&#39;td'+rowCount+'&#39;)"><img src="<?= base_url("images/edit.png");?>" height="20px" width="20px" ></td>' +
								    	'<td onclick="delpicagem('+data.Logid+',&#39;td'+rowCount+'&#39;)"><img src="<?= base_url("images/remove.png");?>" height="20px" width="20px" ></td></tr>');
								    	//ordenar de novo a tabela
								    	startDatatable();
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
		        	}else{
					noty({ 
				    		text: 'A hora da picagem tem que ter o seguinte formato: 12:01:00',
				    		type: "error",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});	
				}
			}
		}
	});
	
}
startDatatable();
</script>