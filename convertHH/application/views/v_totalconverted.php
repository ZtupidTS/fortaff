<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/header_admin');
$this->load->view('template/footer_admin');
?>

<div class="col-md-10 col-md-offset-1">
	<legend>Convertidas / Jogadores</legend>
</div>

<div class="row">
	<div class="col-md-12 col-md-offset-3">
		<form class="form-inline" role="form" method="post" >
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
	  		<input type="button" id="btn_search" value="Procurar" onclick="total()" class="btn btn-default noPrint">
	  		
		</form>
	</div>
</div>

<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-6 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
<?php } ?>

<div class="row">
	<div class="col-md-5 col-md-offset-3 top10" id="returnajax">
	</div>
</div>


<script type="text/javascript">
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

function total()
{
	date1 = $("#datefirst").val();
	date2 = $("#datesecond").val();
	
	var values = {datefirst: date1, datesecond: date2};
	var newform = createform('<?= base_url("home/searchtotal");?>',values);
	
	$.ajax({
	        url: '<?= base_url("home/searchtotal");?>',
	        type: 'post',
	        dataType: 'json',
	        data: $(newform).serializeArray(),
	        beforeSend: function(){
			noty({ 
		    		text: "O pedido esta a ser executado, aguarda por favor.",
		    		type: "information",
		    		layout: "center",
		    		closeWith: ['click', 'hover']
		    	});
		},
	        success: function(data) {
	        		$.noty.closeAll();
	        		//console.log(data);
	  			if(data.return == 'success')
	  			{
					//tabledatatable.destroy();
					$('#returnajax').html(data.message);
					startDatatableRp();					
				}else{
					noty({ 
				    		text: data.message,
				    		type: "error",
				    		layout: "center",
				    		closeWith: ['click', 'hover']
				    	});
				    	$('#returnajax').html('');				    	
				}
	                },
	        error: function(xhr, textStatus, errorThrown) {
	        		$.noty.closeAll();
	        		alert("Erro no envio do pedido por ajax: "+xhr.responseText+" "+errorThrown); 
	        	}
    	});		
	return false;
}
</script>