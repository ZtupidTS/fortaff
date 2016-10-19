<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/header_admin');
$this->load->view('template/footer_admin');
?>
<script type="text/javascript">

</script>

<div class="col-md-10 col-md-offset-1">
	<legend>Modificar Jogador</legend>
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
			                	<select class="selectpicker" id="nickname" name="nickname" onchange="searchplayerdata()">
					  		<option></option>
							<?php
					    		foreach ($result2 as $elem2)
					    		{
								?>
								<option value="<?= $elem2['id_player'];?>"><?= $elem2['nick_player'];?></option>
								<?php
							}
					    		?>
						</select>
			                </div>
		    		</div>
		    		<div class="divhidden" hidden="true">
			    		<div class="form-group">
			    			<label class="col-sm-3 control-label" >Limit Played</label>
			    			<div class="col-sm-6">
				                	<!--<input type="text" class="form-control" id="limit_play" maxlength="50">	-->
			                	  	<select class="selectpicker" id="limit_play" name="limit_play">
						  		<option value="0"></option>
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
						  		<option value="0"></option>
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
			                	  	<select class="selectpicker" id="limit_play3" name="limit_play3">
						  		<option value="0"></option>
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
				                	<input type="text" id="expire_date" name="expire_date" class="form-control" required>
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
				                	<input type="test" id="pathfolder" name="pathfolder" class="form-control" maxlength="200" value="/mnt/hh_share/HH/">
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
			    		<!-- id -->
			    		<div class="form-group" hidden>
			    			<label class="col-sm-3 control-label" >ID</label>
			    			<div class="col-sm-6">
				                	<input type="email" id="id" name="id" class="form-control" maxlength="50" >
				                </div>
			    		</div>
			    		<!-- nickname -->
			    		<div class="form-group" hidden>
			    			<label class="col-sm-3 control-label" >ID</label>
			    			<div class="col-sm-6">
				                	<input type="email" id="nickname2" name="nickname2" class="form-control" maxlength="50" >
				                </div>
			    		</div>
			    		<div class="form-group">
			    			<label class="col-sm-3 control-label" ></label>
			    			<div class="col-sm-6">
			  				<button type="button" id="criar" class="btn btn-default" onclick="modifyPlayer()">Modificar</button>
			  			</div>
			  		</div>	
		  		</div>
		  			
			</form>
		</div>
	</div>
</div>




<script type="text/javascript">
$("#expire_date").datetimepicker({
        language: "pt",
        format: "yyyy-mm-dd",
        weekStart: 1,
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-right",
        minView: 2
});

function searchplayerdata()
{
	var choose = $("#nickname").val();
	var nickname2 = $("#nickname option:selected").text();
	if(choose != "")
	{
		$.ajax({
			url:'<?= base_url("home/getplayer");?>',
			type: 'post',
			dataType: 'json',
		        data: {
		        	id_player : choose
		        } ,
		        success: function(data) {
		        		if(data.return == 'success')
		  			{
						$("#limit_play").val(data.limit_play);
						$("#limit_play2").val(data.limit_play2);
						$("#limit_play3").val(data.limit_play3);
						$("#pathfolder").val(data.pathfolder);
						$("#expire_date").val(data.expire_date);
						$("#email").val(data.email);
						$("#skype").val(data.skype);
						$("#checkbox").val(data.enable);
						$("#id").val(choose);
						$("#nickname2").val(nickname2);
						$(".divhidden").show();
						
						/*noty({ 
					    		text: data.message,
					    		type: "success",
					    		layout: "center",
					    		closeWith: ['click', 'hover']
					    	});*/
						
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
		$(".divhidden").hide();
	}
}


function modifyPlayer()
{
	$.ajax({
	        url: '<?= base_url("home/modifyplayer");?>',
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
						        afterClose: function() {window.location = '<?= base_url("home/viewmodifyplayer");?>';},
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