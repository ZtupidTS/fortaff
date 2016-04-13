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
		<form class="form-inline" role="form" method="post" action="<?= base_url('home/verify_picagens') ?>">
			<div class="form-group">
	    			<label for="email">Intervalo de Datas:</label>
	    			<?php
	    			if(isset($datefirst) && $datefirst != "")
	    			{?>
					<input type="text" id="datefirst" value="<?= $datefirst;?>" class="form-control" required autofocus name="datefirst">	
					<?php	
				}else{?>
					<input type="text" id="datefirst" class="form-control" required autofocus name="datefirst">
					<?php
				}?>
	    		</div>	
	    		<div class="form-group">
	    			<label for="email">a</label>
	    			<?php
	    			if(isset($datesecond) && $datesecond != "")
	    			{?>
					<input type="text" id="datesecond" value="<?= $datesecond;?>" class="form-control" required autofocus name="datesecond">	
					<?php	
				}else{?>
					<input type="text" id="datesecond" class="form-control" required autofocus name="datesecond">
					<?php
				}?>
	  		</div>
	  		<button type="submit" class="btn btn-default">Procurar</button> 		
		</form>
	</div>
</div>
<div class="row top10">
	<?php
	if(isset($error) && $error != "")
	{?>
		<!-- sem resultados -->
		<div class="col-md-10 col-md-offset-1">	
			<div class="col-md-4 col-md-offset-4">
				<?= $error;?>	
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
				        		<th>Ver</th>
				      		</tr>
				    	</thead>
				    	<tbody>
					<?php
					foreach($result as $row)
					{?>
						<tr>
							<td><?= $row['Userid'];?></td>
							<td><?= $row['Name'];?></td>
							<td><?= $row['number'];?></td>
							<td><?= $row['dia'].'-'.$row['mes'].'-'.$row['ano'];?></td>
							<td><a class="various" href="<?= base_url('home/picagens('.$row['Userid'].')');?>"><img src="<?= base_url('images/view.png');?>" height="20px" width="20px" /></a></td>
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
</script>


