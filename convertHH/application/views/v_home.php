<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/header_admin');
$this->load->view('template/footer_admin');

?>

<div class="col-md-10 col-md-offset-1">
	<legend>Visualização Dos Logs</legend>
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
	    			<label>Intervalo de Datas:</label>
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
	    			<label>a</label>
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
	  		<div class="form-group">
				<select class="form-control" id="selecttypelogs">
					<option value="ERROR">Error</option>
					<option value="DEBUG">Debug</option>
					<option value="INFO">Information</option>
					<!--<option value="UTILIZADORES">Utilizadores</option>-->
					<option value="ALL">All Messages</option>
				</select>
			</div>
			 
	  		<input type="button" id="btn_search" value="Procurar" onclick="verLogs()" class="btn btn-default noPrint">
	  		<!--<span class="noPrint">
	  			<img data-toggle="tooltip" title="Imprimir" id="button_print" hidden onclick="window.print();" src="<?= base_url('images/print.png');?>" height="20px" width="20px" >
			</span>	
			<span class="noPrint">
  				<img data-toggle="tooltip" title="Exportar Para Excel" id="button_excel" onclick="printToExcel()" hidden src="<?= base_url('images/excel.png');?>" height="20px" width="20px" >
			</span>
			<span class="noPrint">
  				<img data-toggle="tooltip" title="Refrescar Pagina" id="button_refresh" onclick="refreshPage()" hidden src="<?= base_url('images/refresh.png');?>" height="20px" width="20px" >
			</span>-->
				
		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3 top10" id="returnajax">
	</div>
</div>

<script type="text/javascript">
/*function printToExcel()
{
	tablesToExcel(['logs'], ['Picagens'], 'myfile.xls');
	noty({ 
    		text: 'Exportação concluído e ficheiro transferido. Será necessario refrescar a pagina para realizar uma nova exportação sem erros.',
    		type: "warning",
    		layout: "center",
    		closeWith: ['click', 'hover']
    	});
}*/

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

function verLogs()
{
	date1 = $("#datefirst").val();
	date2 = $("#datesecond").val();
	var typelog = $("#selecttypelogs").val();
	if(date1 == '' || date2 == '')
	{
		noty({ 
	    		text: 'Tem que preencher os campos todos',
	    		type: "error",
	    		layout: "center",
	    		closeWith: ['click', 'hover']
	    	});
	}else{
		var values = {datefirst: date1, datesecond: date2, Typelog: typelog};
		url = '<?= base_url("Home/searchlog");?>';	
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
						/*$('#button_print').show();
						$('#button_excel').show();
						$('#button_refresh').show();*/
					}else{
						noty({ 
					    		text: data.message,
					    		type: "error",
					    		layout: "center",
					    		closeWith: ['click', 'hover']
					    	});
					    	$('#returnajax').html('');
					    	/*$('#button_print').hide();
					    	$('#button_excel').hide();
					    	$('#button_refresh').hide();*/
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
</script>