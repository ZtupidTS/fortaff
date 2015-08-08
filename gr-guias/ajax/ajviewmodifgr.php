<?php
include '../includes/allpageaj.php';

$table = "";

if(is_numeric($_POST['gr_id']))
{
    $table = modifgrGet($_POST['gr_id']);
}else{
    $table = modifgrGet(999999999);
}

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
    if (mysql_num_rows($table) > 0)
    {
        while($data = mysql_fetch_array($table))
        {
            ?>
            <tr>  
                <td><?= $data['gr_id'];?></td>
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
    ?>  
    </tbody>
</table>

<?php
closeDataBase();
?>