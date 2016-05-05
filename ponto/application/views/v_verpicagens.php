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
		  	}?>
	  		<input type="button" id="btn_search" value="Procurar" onclick="verpicagens()" class="btn btn-default noPrint">
	  		<span class="noPrint">
	  			<img id="button_print" hidden onclick="window.print();" src="<?= base_url('images/print.png');?>" height="20px" width="20px" >
			</span>
		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3 top10" id="returnajax">
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

function verpicagens()
{
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
		var newform = createform('<?= base_url("home/picagembyuser");?>',values);
		$.ajax({
		        url: '<?= base_url("home/picagembyuser");?>',
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
						$('#returnajax').html(data.message);
						$('#button_print').show();
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