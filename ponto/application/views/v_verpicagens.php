<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->session->userdata('level') == 2)
{
	$this->load->view('template/header_admin');
	$this->load->view('template/footer_admin');
}
if($this->session->userdata('level') == 1)
{
	$this->load->view('template/header_user');
	$this->load->view('template/footer_user');
}
?>

<div class="col-md-10 col-md-offset-1">
	<legend>Visualização Picagens</legend>
</div>

<div class="row">
<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-6 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
<?php } ?>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-3">
		<form class="form-inline" role="form" method="post" action="<?= base_url('home/');?>">
			<div class="form-group">
	    			<label for="email">Intervalo de Datas:</label>
	    			<?php
	    			if(isset($datefirst) && $datefirst != "")
	    			{?>
					<input type="text" id="datefirst" value="<?= $datefirst;?>" class="form-control" required name="datefirst">	
					<?php	
				}else{?>
					<input type="text" id="datefirst" class="form-control" required name="datefirst">
					<?php
				}?>
	    		</div>	
	    		<div class="form-group">
	    			<label for="email">a</label>
	    			<?php
	    			if(isset($datesecond) && $datesecond != "")
	    			{?>
					<input type="text" id="datesecond" value="<?= $datesecond;?>" class="form-control" required name="datesecond">	
					<?php	
				}else{?>
					<input type="text" id="datesecond" class="form-control" required name="datesecond">
					<?php
				}?>
	  		</div>
	  		<?php
	  		if(isset($result))
	    		{
		  		if($this->session->userdata('level') == 2)
		  		{
					?>	
			  		<div class="form-group">
						<select class="form-control" id="selectuser">
							<option value="999999">Todos (não podem editar picagens)</option>
							<?php
							foreach($result->result() as $row)
							{
								?>
								<option value="<?= $row->Userid;?>"><?= $row->Userid.' - '.$row->Name;?></option>
								<?php
							}?>
						</select>
					</div>
			  		<?php			  		
		  		}
		  	}
		  	if($this->session->userdata('level') == 1)
	  		{
				?>
				<div class="form-group">
					<select class="form-control" id="selectuser">
						<option value="<?= $this->session->userdata('user_id');?>"><?= $this->session->userdata('user_id').' - '.$this->session->userdata('nome');?></option>
						<?php
						foreach($this->session->userdata('arr_user') as $row)
						{
							?>
							<option value="<?= $row['Userid'];?>"><?= $row['Userid'].' - '.$row['Name'];?></option>
							<?php
						}?>
					</select>
				</div>
		  		<?php			  		
	  		}
		  	?>
	  		<input type="button" id="btn_search" value="Procurar" onclick="verpicagens()" class="btn btn-default noPrint">
	  		<span class="noPrint">
	  			<img data-toggle="tooltip" title="Imprimir" id="button_print" hidden onclick="window.print();" src="<?= base_url('images/print.png');?>" height="20px" width="20px" >
			</span>	
			<?php
			if($this->session->userdata('level') != 1)
	  		{?>
				<span class="noPrint">
	  				<img data-toggle="tooltip" title="Exportar Para Excel" id="button_excel" onclick="printToExcel()" hidden src="<?= base_url('images/excel.png');?>" height="20px" width="20px" >
				</span>
				<span class="noPrint">
	  				<img data-toggle="tooltip" title="Refrescar Pagina" id="button_refresh" onclick="refreshPage()" hidden src="<?= base_url('images/refresh.png');?>" height="20px" width="20px" >
				</span>
				<?php
			}?>	
		</form>
	</div>
</div>
<div class="row noPrint">
	<p class="col-md-8 col-md-offset-3 top10 text-danger">*Clica na linha que quer editar as picagens</p>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3 top10" id="returnajax">
	</div>
</div>

<!-- Form modal -->
<div class="modal fade" id="modalChangePicagem" tabindex="-1" role="dialog" >
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="formmodal" name="formmodal" role="form" method="post" hidden="true" action="<?= base_url("home/obter_picagens");?>" target="_blank">
				<div class="modal-body">
					<div class="form-group" hidden>
						<input type="text" class="form-control" name="nome" id="nome">
						<input type="text" class="form-control" name="datapicagem" id="datapicagem" >
						<input type="text" class="form-control" name="iduser" id="iduser" >
					</div>
				</div>				
			</form>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
var arraytable = new Array();

function printToExcel()
{
	tablesToExcel(arraytable, ['Picagens'], 'myfile.xls');
	noty({ 
    		text: 'Exportação concluído e ficheiro transferido. Será necessario refrescar a pagina para realizar uma nova exportação sem erros.',
    		type: "warning",
    		layout: "center",
    		closeWith: ['click', 'hover']
    	});
}

$("#datefirst").datetimepicker({
        language: "pt",
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-right",
        minView: 2
});
$("#datesecond").datetimepicker({
        language: "pt",
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-right",
        minView: 2
});

function verpicagens()
{
	arraytable = new Array();
	date1 = $("#datefirst").val();
	date2 = $("#datesecond").val();
	var user = $("#selectuser").val();
	if(user == '' || date1 == '' || date2 == '')
	{
		noty({ 
	    		text: 'Tem que preencher os campos todos',
	    		type: "error",
	    		layout: "center",
	    		closeWith: ['click', 'hover']
	    	});
	}else{
		var values = {datefirst: date1, datesecond: date2, Userid: user};
		var url = ''
		if(user == '999999')
		{
			url = '<?= base_url("home/picagemAll");?>';	
		}else{
			url = '<?= base_url("home/picagembyuser");?>';
		}
		var newform = createform(url,values);
		$.ajax({
		        url: url,
		        type: 'post',
		        dataType: 'json',
		        data: $(newform).serializeArray(),
		        beforeSend: function(){
				noty({ 
			    		text: "O pedido esta a ser executado, aguarda por favor.",
			    		type: "information",
			    		layout: "center"
			    		//closeWith: ['click', 'hover']
			    	});
			},
		        success: function(data) {
		        		$.noty.closeAll();
		        		//console.log(data);
		  			if(data.return == 'success')
		  			{
						$('#returnajax').html(data.message);
						$('#button_print').show();
						$('#button_excel').show();
						$('#button_refresh').show();
						
						for (var i = 0; i < data.array_table.length; i++) {
					        	arraytable.push(data.array_table[i]);
					        }
					}else{
						noty({ 
					    		text: data.message,
					    		type: "error",
					    		layout: "center",
					    		closeWith: ['click', 'hover']
					    	});
					    	$('#returnajax').html('');
					    	$('#button_print').hide();
					    	$('#button_excel').hide();
					    	$('#button_refresh').hide();
					}
		                },
		        error: function(xhr, textStatus, errorThrown) {
		        		$.noty.closeAll();
		        		alert("Erro no envio do pedido por ajax: "+xhr.responseText+" "+errorThrown); 
		        	}
	    	});		
		return false;
	}
}

function corrigirPicagens(datapicagem)
{
	var user = $("#selectuser").val();
	var admin = "<?= $this->session->userdata('level');?>";
	if(user != '999999' && admin != '1')
	{
		var newdate = datapicagem.toString().substr(0,4)+'-'+datapicagem.toString().substr(4,2)+'-'+datapicagem.toString().substr(6,2);
		$("#datapicagem").val(newdate);
		var nameselect = $('#selectuser option:selected').text();
		var namesplit = nameselect.split("-");
		$("#nome").val(namesplit[1]);
		$("#iduser").val($("#selectuser").val());
		$('#formmodal').submit();	
	}else{
		if(admin != '1')
		{
			noty({ 
		    		text: "Seleccionando a loja não dá para editar picagens, seleciona um funcionario de cada vez",
		    		type: "error",
		    		layout: "center",
		    		closeWith: ['click', 'hover']
		    	});	
		}
	}
}
</script>