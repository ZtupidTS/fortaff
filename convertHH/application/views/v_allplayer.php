<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/header_admin');
$this->load->view('template/footer_admin');
?>

<div class="col-md-10 col-md-offset-1">
	<legend>Jogadores</legend>
</div>

<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<table class="table table-hover handsdia display" id="handsdia">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nick</th>
					<th>Limit</th>
					<th>Limit</th>
					<th>Limit</th>
					<th>Path</th>
					<th>Expire</th>
					<th>Email</th>
					<th>Skype</th>
					<th>Enable</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($result as $elem)
				{?>
					<tr>
						<td><?= $elem['id_player'];?></td>
						<td><?= $elem['nick_player'];?></td>
						<td>
						<?php
							$result_namelimit = $this->All_model->getlimitbyid($elem['limit_play']);
							echo $result_namelimit->name_limit;
						?>	
						</td>
						<td>
						<?php
							$result_namelimit = $this->All_model->getlimitbyid($elem['limit_play2']);
							echo $result_namelimit->name_limit;
						?>	
						</td>
						<td>
						<?php
							$result_namelimit = $this->All_model->getlimitbyid($elem['limit_play3']);
							echo $result_namelimit->name_limit;
						?>	
						</td>
						<td><?= $elem['pathfolder'];?></td>
						<td><?= $elem['expire_date'];?></td>
						<td><?= $elem['email'];?></td>
						<td><?= $elem['skype'];?></td>
						<td><?= $elem['enable'];?></td>
					</tr>
					<?php
				}?>
			</tbody>
		</table>
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

function handdia()
{
	date1 = $("#datefirst").val();
	date2 = $("#datesecond").val();
	var limit = $("#selectlimit").val();
	
	var values = {datefirst: date1, datesecond: date2, id_limit: limit};
	var newform = createform('<?= base_url("home/searchhanddia");?>',values);
	
	$.ajax({
	        url: '<?= base_url("home/searchhanddia");?>',
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