<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/header_admin');
$this->load->view('template/footer_admin');
?>
<script type="text/javascript">

</script>

<div class="col-md-10 col-md-offset-1">
	<legend>Criação de jogador</legend>
</div>

<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-5 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
<?php } ?>

<div class="container">
	<div class="row top10">
		<div class="col-md-6 col-md-offset-2">
			<form id="addplayer" name="addplayer" class="form-horizontal">
				<div class="form-group">
		    			<label class="col-sm-3 control-label" >Nickname</label>
		    			<div class="col-sm-6">
			                	<input type="text" class="form-control" id="nickname" name="nickname" maxlength="50">
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Limit Played</label>
		    			<div class="col-sm-6">
			                	<!--<input type="text" class="form-control" id="limit_play" maxlength="50">	-->
		                	  	<select class="selectpicker" id="limit_play" name="limit_play">
					  		<option></option>
							<?php
					    		foreach ($result as &$elem)
					    		{
								?>
								<option value="<?= $elem['id_limit'];?>"><?= $elem['name_limit'];?></option>
								<?php
							}
					    		?>
						</select>
						
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Limit Played2</label>
		    			<div class="col-sm-6">
			                	<!--<input type="text" class="form-control" id="limit_play" maxlength="50">	-->
		                	  	<select class="selectpicker" id="limit_play2" name="limit_play2">
					  		<option value=""></option>
							<?php
					    		foreach ($result as &$elem)
					    		{
								?>
								<option value="<?= $elem['id_limit'];?>"><?= $elem['name_limit'];?></option>
								<?php
							}
					    		?>
						</select>
						
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Expire Date</label>
		    			<div class="col-sm-6">
			                	<input type="text" id="dateexpire" name="dateexpire" class="form-control" required>
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Email</label>
		    			<div class="col-sm-6">
			                	<input type="email" id="email" name="email" class="form-control" maxlength="100" required >
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Skype</label>
		    			<div class="col-sm-6">
			                	<input type="email" id="skype" name="skype" class="form-control" maxlength="50" >
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Path</label>
		    			<div class="col-sm-6">
			                	<input type="test" id="path" name="path" class="form-control" maxlength="200" value="/mnt/hh_share/HH/">
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" >Enable</label>
		    			<div class="col-sm-6">
			                	<select class="selectpicker" id="checkbox" name="checkbox">
					  		<option value="1" selected>Yes</option>							
					  		<option value="0">No</option>							
						</select>
			                </div>
		    		</div>
		    		<div class="form-group">
		    			<label class="col-sm-3 control-label" ></label>
		    			<div class="col-sm-6">
		  				<button type="button" id="criar" class="btn btn-default" onclick="addPlayer()">Criar</button> 	
		  			</div>
		  		</div>	
		  			
			</form>
		</div>
	</div>
</div>




<script type="text/javascript">
$("#dateexpire").datetimepicker({
        language: "pt",
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-right",
        minView: 2
});


function addPlayer()
{
	$.ajax({
	        url: '<?= base_url("home/insertplayer");?>',
	        type: 'post',
	        dataType: 'json',
	        data: $('#addplayer').serializeArray(),
	        success: function(data) {
	        		if(data.return == 'success')
	  			{
					noty({ 
				    		text: data.message,
				    		type: "success",
				    		layout: "center",
				    		callback: {
						        afterClose: function() {window.location = '<?= base_url("home/index");?>';},
						},
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
	        		alert("Erro no envio do pedido por ajax: "+xhr.responseText); 
	        	}
    	});
}
</script>