<?php
include '../includes/allpageaj.php';

$table = "";

if(is_numeric($_GET['idenc']))
{
    $table = modifEncomendasGetByFiltro("pp_modif_enc_id = ".$_GET['idenc'], "pp_modif_id");
}else{
    $table = modifEncomendasGetByFiltro("pp_modif_enc_id = 999999999", "pp_modif_id");
}

//print_r($table);

?>
<table class="table table-striped table-hover">
    <thead>  
          <tr>  
            <th>Nº Encomenda</th> 
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
                <td><?= $data['pp_modif_enc_id'];?></td>
                <td>
                    <?php
                        $data2 = usersGetById($data['pp_modif_us_id']);
                        echo $data2['pp_us_name'];
                    ?>
                </td>
                <td><?= $data['pp_modif_date'];?></td>
                <td><?= $data['pp_modif_texto'];?></td>                
            </tr>
            <?php
        }        
    }else{?>
        <tr>
            <td colspan="5" style="text-align: center;">Não há resultados, verificar numero inserido</td> 
        </tr>    
        <?php
    }
    ?>  
    </tbody>
</table>

<?php
closeDataBase();
?>