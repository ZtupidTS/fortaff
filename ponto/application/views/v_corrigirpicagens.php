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
<?php
/*echo $iduser.' ';
echo $datapicagem.' ';
echo $datefirst.' ';
echo $datesecond.' ';
echo print_r($result);*/
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
				<table class="table table-hover">
					<caption>
						<form hidden id="formback" class="form-inline" role="form" method="post" action="<?= base_url('home/verify_picagens');?>">
							<input type="text" id="datefirst" value="<?= $datefirst;?>" class="form-control" required name="datefirst">	
							<input type="text" id="datesecond" value="<?= $datesecond;?>" class="form-control" required name="datesecond">							
						</form>
						<button type="button" id="btn_back" class="btn btn-default" onclick="submitformback()">Voltar</button>
						<?php 
						$newdate = date_create($datapicagem);
						echo $nomeuser.' Do Dia '.date_format($newdate,'d-m-Y');
						?>	
					</caption>
					<thead>
				      		<tr>
				        		<th>Logid</th>
				        		<th>CheckTime</th>
				        		<th></th>
				        		<th></th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					$i = 1;
					foreach($result as $row)
					{?>
						<tr>
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
			</div>
			<?php
		}
	}?>
</div>

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
	/*var new1 = pName.split(':');
	alert(new1[0]);*/
}
function delpicagem(logid,td)
{
	newtd = '#'+td;
	$('#logid').val(logid);
	$.ajax({
	        url: '<?= base_url("home/del_picagem");?>',
	        type: 'post',
	        dataType: 'text',
	        data: $('#formmodal').serializeArray(),
	        success: function(data) {
	        		//console.log(data);
	  			alert(data);
	  			$('#modalclose').click();
	                },
	        error: function(xhr, textStatus, errorThrown) {
	        		alert("Não foi possível eliminar a picagem, o erro: "+xhr.responseText); 
	        	}
    	});
    	return false;
}
$('#formmodal').submit(function() {
	var novapica = $('#novapicagem').val();
	$.ajax({
	        url: '<?= base_url("home/editar_picagem");?>',
	        type: 'post',
	        dataType: 'text',
	        data: $('#formmodal').serializeArray(),
	        success: function(data) {
	        		//console.log(data);
	  			alert(data);
	  			$(newtd).html(novapica+':00');
	  			$('#modalclose').click();
	                },
	        error: function(xhr, textStatus, errorThrown) {
	        		alert("Não foi guardado a atualização, o erro: "+xhr.responseText); 
	        	}
    	});
    	return false;
}); 

function submitformback()
{
	$('#formback').submit();
}
</script>