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
	<legend>Feriados</legend>
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
				<table class="table table-hover holiday display" id="holiday">
					<thead>
				      		<tr>
				        		<th data-sort="int">Holidayid</th>
				        		<th>Nome</th>
				        		<th>Data</th>				        		
				        		<th>Editar</th>				        		
				        		<th>Eliminar</th>				        		
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					$i = 1;
					foreach($result as $row)
					{?>
						<tr class="<?= 'tr'.$i;?>">
							<td><?= $row['Holidayid'];?></td>
							<td id="<?= 'name'.$i;?>"><?= $row['Name'];?></td>
							<td id="<?= 'td'.$i;?>">
								<?php
								$newdate = date_create($row['BDate']);
								echo date_format($newdate,'Y-m-d');
								?>	
							</td>
							<td onclick="editHoliday(<?= $row['Holidayid'];?>,<?= $i;?>)"><img src="<?= base_url('images/edit.png');?>" height="20px" width="20px" ></td>
							<td onclick="delHoliday(<?= $row['Holidayid'];?>,<?= $i;?>)"><img src="<?= base_url('images/remove.png');?>" height="20px" width="20px" ></td>
						</tr>
						<?php
						$i++;
					}?>
					</tbody>
				</table>
				<div>
					<button type="button" class="btn btn-default pull-right" onclick="addHoliday()">Adicionar Feriado/Inventario</button>
				</div>
				<div class="top60">
					*Para os inventarios inserir o nome assim: INV_00:00:00 onde 00:00:00 
					tem que corresponder a hora de inicio do INV, ex: INV_21:00:00
				</div>				
			</div>
			<?php
		}
	}?>
</div>

<script>

function editHoliday(holidayid,ciclo)
{
	var newtd = '#td'+ciclo;
	var newtdname = '#name'+ciclo;
	var dateold = $.trim($(newtd).html());
	var nameold = $.trim($(newtdname).html());
	
	/*$('#antigapicagem').val(horaold);
	$('#logid').val(logid);
	$('#novapicagem').val('');	
	$('#modalChangePicagem').modal({
		keyboard: true	
	});*/	
	
	Lobibox.prompt('text',{
	    	title: 'Nome: '+nameold,
	    	buttonsAlign: 'right',
	    	draggable: true,
	    	value: nameold,
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
		        	var namenew = $this.getValue();
		        	Lobibox.prompt('date',{
				    	title: 'Data: '+dateold,
				    	buttonsAlign: 'right',
				    	draggable: true,
				    	value: dateold,
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
		        				var datenew = $this.getValue();
		        				//alert(datenew+' '+namenew);
		        				var values = {Holidayid: holidayid, BDate: datenew, Name: namenew};
							var newform = createform('<?= base_url("home/editar_holiday");?>',values);
		        				$.ajax({
							        url: '<?= base_url("home/editar_holiday");?>',
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
										    	$(newtd).html(datenew);
										    	$(newtdname).html(namenew);
										    	//ordenar de novo a tabela
										    	startDatatableHol();
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
		}
	});
}
function delHoliday(holidayid,ciclo)
{
	var newtd = '#td'+ciclo;
	var newtr = '.tr'+ciclo;
	var newtdname = '#name'+ciclo;
	var nameold = $.trim($(newtdname).html());
	/*alert(newtd+' '+newtd);
	var dateold = $.trim($(newtd).html());
	var nameold = $.trim($(newtdname).html());*/
	//var dateold = $.trim($(newtd).html());
	//var nameold = $.trim($(newtdname).html());
	
	//newtr = '.' +td;
	//$('#logid').val(logid);
	
    	Lobibox.confirm({
	    	msg: "Pretende eliminar esse feriado '"+nameold+"'? (não se pode voltar atrás)",
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
				var values = {Holidayid: holidayid};
				var newform = createform('<?= base_url("home/del_holiday");?>',values);
				$.ajax({
				        url: '<?= base_url("home/del_holiday");?>',
				        type: 'post',
				        dataType: 'json',
				        data: $(newform).serializeArray(),
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
function addHoliday()
{
	Lobibox.prompt('text',{
	    	title: 'Insere o Nome:',
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
	    	callback: function ($this, type, ev) {
		        if(type == 'ok')
		        {
		        	var namenew = $this.getValue();
		        	Lobibox.prompt('date',{
				    	title: 'Insira a Data:',
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
				    	callback: function ($this, type, ev) {
					        if(type == 'ok')
		        			{
		        				var datenew = $this.getValue();
		        				//alert(datenew+' '+namenew);
		        				var values = {BDate: datenew, Name: namenew};
							var newform = createform('<?= base_url("home/add_holiday");?>',values);
		        				$.ajax({
							        url: '<?= base_url("home/add_holiday");?>',
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
										    	
										    	tabledatatable.destroy();
										    	var rowCount = $('.holiday tr').length;
										    	$('.holiday').last().append('<tr class="tr'+rowCount+'"><td>'+data.Holidayid+'</td><td id="name'+rowCount+'">'+namenew+'</td><td id="td'+rowCount+'">'+datenew+'</td><td onclick="editHoliday('+data.Holidayid+','+rowCount+')"><img src="<?= base_url("images/edit.png");?>" height="20px" width="20px" ></td>' +
										    	'<td onclick="delHoliday('+data.Holidayid+','+rowCount+')"><img src="<?= base_url("images/remove.png");?>" height="20px" width="20px" ></td></tr>');
										    	//ordenar de novo a tabela
										    	startDatatableHol();
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
		}
	});
	
}
startDatatableHol();
</script>