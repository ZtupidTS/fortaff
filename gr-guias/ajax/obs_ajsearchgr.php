<?php
include '../includes/allpageaj.php';

$where = "";
$order = "";

switch ($_POST['campo']) {
  case "id":
    $where .= $_POST['campo'] . " = " . $_POST['valor'];
    break;
  case "art_type":
    $where .= $_POST['campo'] . " LIKE " .  dbString("%" . $_POST['valor'] . "%");
    break;  
  case "art_marca":
    $where .= $_POST['campo'] . " LIKE " .  dbString("%" . $_POST['valor'] . "%");
    break;  
  case "cl_name":
    $where .= $_POST['campo'] . " LIKE " .  dbString("%" . $_POST['valor'] . "%");
    break;
  case "cl_telefone":
    if(is_numeric($_POST['valor']) && strlen($_POST['valor']) > 8)
    {
        $where .= $_POST['campo'] . " = " . dbInteger($_POST['valor']);
    }else{
        $where .= $_POST['campo'] . " = 999999999";
    }
    break;
  case "status_sms":
  	switch(strtoupper($_POST['valor'])){
	  	case "E":
	  		$where .= $_POST['campo'] . " = 1";
	  		break;
	  	case "P":
	  		$where .= $_POST['campo'] . " = 2";
	  		break;
	  	case "N":
	  		$where .= $_POST['campo'] . " = 3";
	  		break;
	  	case "NP":
	  		$where .= $_POST['campo'] . " = 0";
	  		break;
	  }
    break;
  case "allguias":
    $where .= "id > 0";
    $order = " DESC";
    break;
}

$where .= " AND gr_enable = 1";



$table = grepGetByFiltro($where, "date_in".$order);
?>


<!-- <table id="example" class="table table-striped table-hover"> -->
<table id="mytable" class="table table-striped table-bordered display" cellspacing="0" width="100%">
    <thead>  
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
            <tr onclick="viewGr('<?= $data['id'];?>');">  
                <td><?= $data['id'];?></td>  
                <td><?= $data['cl_name'];?></td>
                <td><?= $data['cl_telefone'];?></td>
                <td><?= $data['date_in'];?></td>
                <td><?= $data['date_torep'];?></td>
                <td><?= $data['date_sms'];?></td>
                <td>
                	<?php
                	switch($data['status_sms']){
				case 1:
					echo "E";
					break;
				case 2:
					echo "P";
					break;
				case 3:
					echo "N";
					break;
				case 0:
					echo "NP";
					break;
				default:
					break;
			}?>
                	
                </td>
                <td><?= $data['date_tocliente'];?></td>                
            </tr>
            <?php
        }        
    }else{?>
        <tr>
            <td colspan="8" style="text-align: center;">Não há resultados</td> 
        </tr>    
        <?php
    }
    }
    ?>  
    </tbody>
</table>
E = Entregue, P = Pendente, N = Não entregue, NP = Não Processada
<?php
closeDataBase();
?>                    