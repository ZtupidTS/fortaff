<?php
include '../includes/connectDB.php';
include '../fonction/fonction.php';

$hand = control_post($_POST['hand']);

if($hand != "")
{
    mysql_query("DELETE FROM tgt_posthands WHERE id = '$hand'");
    #mysql_close($conexao);
    if(mysql_affected_rows() > 0)
    {
        mysql_close($conexao);
        unlink("../convers/log".$hand.".html");
        echo 'Hand delete';        
    }else{
        mysql_close($conexao);
        echo "Hand no delete, view this with administrator";
    }
}else{
    mysql_close($conexao);
    echo 'Refresh page and insert';
}
?>