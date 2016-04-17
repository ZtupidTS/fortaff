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
	<legend>Problemas Picagens</legend>
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form class="form-inline" role="form" method="post" action="<?= base_url('home/verify_picagens');?>">
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
	  		<button type="submit" id="btn_search" class="btn btn-default">Procurar</button> 		
		</form>
	</div>
</div>
<?php if (isset($erro)){ ?>
	<div class="alert alert-danger col-md-6 col-md-offset-3" role="alert" style="margin-top: 10px;"><?= $erro; ?></div>
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
			<div class="col-md-6 col-md-offset-3 table-responsive">
				<table class="table table-hover">
					<thead>
				      		<tr>
				        		<th>Nº</th>
				        		<th>Nome</th>
				        		<th>Picagens</th>
				        		<th>Data</th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					foreach($result as $row)
					{?>
						<tr onclick="verificarpicagens(<?= $row['Userid'];?>,<?= $row['ano'].$row['mes'].$row['dia'];?>,'<?= $row['Name'];?>')">
							<td><?= $row['Userid'];?></td>
							<td><?= $row['Name'];?></td>
							<td><?= $row['number'];?></td>
							<td><?= $row['dia'].'-'.$row['mes'].'-'.$row['ano'];?></td>
						</tr>
						<?php
					}?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}?>
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

function verificarpicagens(userid,data_picagem,name)
{
	date1 = $("#datefirst").val();
	date2 = $("#datesecond").val();
	var newdate = data_picagem.toString().substr(0,4)+'-'+data_picagem.toString().substr(4,2)+'-'+data_picagem.toString().substr(6,2);
	var url = '<?= base_url("home/obter_picagens");?>';
	var values = {iduser: userid, datapicagem: newdate, datefirst: date1, datesecond: date2, nome: name};
	submitform(url, values);
}
</script>