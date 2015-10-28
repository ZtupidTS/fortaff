<?php
include '../includes/allpageaj.php';

$table = "";

if (strpos($_POST['gr_id'],'-') !== false) 
{
	$data = grepGetByGrNumber($_POST['gr_id']);
	$table = modifgrGet($data['id']);
}else{
	//$data = grepGetById($_POST['id_gr']);	
	$table = modifgrGet($_POST['gr_id']);
}



/*if(is_numeric($_POST['gr_id']))
{
    $table = modifgrGet($_POST['gr_id']);
}else{
    $table = modifgrGet(999999999);
}*/

?>
<table class="table table-striped table-hover">
    <thead>  
          <tr>  
            <th>Nº Guia</th> 
            <th>Nome Utilizador</th> 
            <th>data Modificação</th>  
            <th>Motivo</th>            
          </tr>  
    </thead>
    <tbody> 
    <?php
    if (is_bool($table) === false) 
    {
	    if (mysql_num_rows($table) > 0)
	    {
	        while($data = mysql_fetch_array($table))
	        {
	            ?>
	            <tr>  
	                <td>
	                	<?php
	                	if($data['gr_number'] == "")
	                      	{
					$idguia = $data['gr_id'];
				}else{
					$idguia = $data['gr_number'];
				}
	                	echo $idguia;
	                	?>                		
	                </td>
	                <td>
	                    <?php
	                        $data2 = loginGet($data['us_id']);
	                        echo $data2['us_name'];
	                    ?>
	                </td>
	                <td><?= $data['modif_date'];?></td>
	                <td><?= $data['modif_text'];?></td>                
	            </tr>
	            <?php
	        }        
	    }else{?>
	        <tr>
	            <td colspan="5" style="text-align: center;">Não há resultados</td> 
	        </tr>    
	        <?php
	    }
    }else{?>
    	<tr>
	    <td colspan="5" style="text-align: center;">Não há resultados</td> 
	</tr>
	<?php
    }
    ?>  
    </tbody>
</table>

<?php
closeDataBase();
?>