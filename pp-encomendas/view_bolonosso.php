<?php include 'includes/header.php'; ?>

	<?php
	$table = viewBoloGetByFiltro("pp_bolo_enable = 1", "");
	?>
	
	<table id="mytable" class="table table-bordered display" cellspacing="0" width="">
	    <!--<thead>  
	          <tr>  
	            <th>Nº</th>  
	            <th>Nome</th> 
	            <th>Contacto</th> 
	            <th>Data Entrada</th>  
	            <th>Data Reparador</th>
	            <th>Data SMS</th>
	            <th>Entregue?</th>
	            <th>Data Levantamento</th>
	          </tr>  
	    </thead>-->
	    <tbody> 
	    <?php
	    if (is_bool($table) === false) 
	    {
	    	    if (mysql_num_rows($table) > 0)
		    {
		        while($data = mysql_fetch_array($table))
		        {
		            ?>
		            <tr class="text-center" onclick="viewGr('<?= $data['pp_bolo_id'];?>');">  
		            	<td colspan="2" bgcolor="#535455" ><font color="#ffffff"><?= $data['pp_bolo_nome'];?></font></td>  
		            </tr>
		            <tr>
		                <td rowspan="3" width="255">
		                	<a href="insert_enc_bolo.php?pp_bolo_id=<?= $data['pp_bolo_id'];?>"><img height="150" width="250" src="<?= $data['pp_bolo_urlimage'];?>"/></a></td>  
		                <td>
		                	<b>Cobertura:</b></br>
		                	<?= $data['pp_cobertura_designacao'];?>
		                </td>
		            </tr>
		            <tr> 
		                <td>
		                	<b>Recheio:</b></br>
		                	<?= $data['pp_recheio_designacao'];?>
		                </td>
		            </tr>
		            <tr>
		                <td>
		                	<b>Massa:</b></br>
		                	<?= $data['pp_massa_designacao'];?>
		                </td>		                
		            </tr>
		            <?php
	        	}        
		    }else{?>
		        <tr>
		            <td colspan="2" style="text-align: center;">Não há resultados</td> 
		        </tr>    
		        <?php
		    }
	    }
	    ?>  
	    </tbody>
	</table>

<?php include 'includes/footer.php';?>