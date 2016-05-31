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
	<legend>Resumo Semanal</legend>
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
		  		?>
		  		<div class="form-group">
					<select class="form-control" id="selectdpt">
						<?php
						$separator = 0;
			 			foreach($result as $row)
						{
							if($row['Deptid'] != '1')	
							{	
								if($row['SupDeptid'] < VAL_DPT)
								{
									if($row['Deptid'] != 24)
									{
										if($row['SupDeptid'] == 1)
										{?>
											<option value="<?= $row['Deptid'];?>"><?= $row['DeptName']. ' (Exceto Chefias e Rep Ext)';?></option>
											<?php
										}else{?>
											<option value="<?= $row['Deptid'];?>"><?= $row['DeptName'];?></option>
											<?php
										}	
									}
								}else{
									if($separator == 0)
									{
										$separator++;
										?>
										<option value="">-----------------------------------------</option>
										<option value="<?= $row['Deptid'];?>"><?= $row['DeptName'];?></option>	
										<?php
									}else{
										?>
										<option value="<?= $row['Deptid'];?>"><?= $row['DeptName'];?></option>
										<?php
									}
								}
							}
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

<div class="row">
	<div class="col-md-4 col-md-offset-4 top10" id="returnajax">
	</div>
</div>

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
        language: 'pt',
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-right",
        minView: 2
});
$("#datesecond").datetimepicker({
        language: 'pt',
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
	var dpt = $("#selectdpt").val();
	if(dpt == '')
	{
		noty({ 
	    		text: 'Tem que seleccionar uma secção ou departamento',
	    		type: "error",
	    		layout: "center",
	    		closeWith: ['click', 'hover']
	    	});
	}else{
		var values = {datefirst: date1, datesecond: date2, departamento: dpt};
		var url = '<?= base_url("home/picagemResumosemanal");?>';	
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