<?php
include '../includes/allpageaj.php';

$where = "";

switch ($_POST['campo']) {
  case "rep_name":
    $where .= $_POST['campo'] . " LIKE " .  dbString("%" . $_POST['valor'] . "%");
    break;
  case "rep_telefone":
    if(is_numeric($_POST['valor']) && strlen($_POST['valor']) > 8)
    {
        $where .= "rep_telefone1 = " . dbInteger($_POST['valor']) . " OR  rep_telefone2 = " . dbInteger($_POST['valor']);
    }else{
        $where .= "rep_telefone1 = 999999999";
    }
    break;
  case "rep_id":
 	$where .= $_POST['campo'] . " = " .  dbInteger($_POST['valor']);
    	break;
}

$where .= " AND rep_enable = 1";

$table = reparadorGetByFiltro($where, "rep_id");
?>
<table class="table table-striped table-hover">
    <thead>  
          <tr>  
            <th>Nº</th>  
            <th>Nome</th> 
            <th>Email</th> 
            <th>Email2</th>
            <th>Contacto</th>
            <th>Nome</th>
            <th>Contacto 2</th>
            <th>Nome 2</th>
          </tr>  
    </thead>
    <tbody> 
    <?php
    if (mysql_num_rows($table) > 0)
    {
        while($data = mysql_fetch_array($table))
        {
            ?>
            <tr onclick="viewReparador('<?= $data['rep_id'];?>');">  
                <td><?= $data['rep_id'];?></td>  
                <td><?= $data['rep_name'];?></td>
                <td><?= $data['rep_email'];?></td>
                <td><?= $data['rep_email2'];?></td>
                <td><?= $data['rep_telefone1'];?></td>
                <td><?= $data['rep_nome1'];?></td>
                <td><?= $data['rep_telefone2'];?></td>                
                <td><?= $data['rep_nome2'];?></td>
            </tr>
            <?php
        }        
    }else{?>
        <tr>
            <td colspan="8" style="text-align: center;">Não há resultados</td> 
        </tr>    
        <?php
    }
    ?>  
    </tbody>
</table>

<?php
closeDataBase();
?>
                    