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
	<legend>Exportar Para o Sage Next</legend>
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
							<option value="999999">Todos (Exceto Admin. e Rep. Externos)</option>
						</select>
					</div>
			  		<?php			  		
		  		}
		  	}
		  	?>
	  		<input type="button" id="btn_search" value="Exportar" onclick="exportsage()" class="btn btn-default noPrint">
		</form>
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

function exportsage()
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
		var url2 = '<?= base_url("home/exporttosage");?>'
		var newform = createform(url2,values);
		$.ajax({
		        url: url2,
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
						downloadDataUrlFromJavascript("sage.txt","<?= base_url().'export/sage.txt';?>");
						noty({ 
					    		text: data.message,
					    		type: "success",
					    		layout: "center",
					    		closeWith: ['click', 'hover']
					    	});
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
		        		$.noty.closeAll();
		        		alert("Erro no envio do pedido por ajax: "+xhr.responseText+" "+errorThrown); 
		        	}
	    	});		
		return false;
	}
}
</script>