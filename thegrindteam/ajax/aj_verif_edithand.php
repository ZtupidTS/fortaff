<?php
include '../includes/connectDB.php';
include '../fonction/fonction.php';

$id = control_post($_POST['id']);
$iduser = control_post($_POST['iduser']);
$title = control_post($_POST['title']);
$hand = control_post($_POST['hand']);
$thinkingprocess = $_POST['thinkingprocess'];
$image = $_POST['image'];
$class = $_POST['class'];

$stringempty = true;

if($iduser == "")
{
    $stringempty = false;
    $mensagem = "Verifier id user";
}

if($stringempty && $title == "")
{
    $stringempty = false;
    $mensagem = "Insert Title";
}

if($stringempty && $hand == "")
{
    $stringempty = false;
    $mensagem = "Insert hand";
}

if($stringempty && $thinkingprocess == "")
{
    $stringempty = false;
    $mensagem = "Insert thinking process";
}

if($stringempty)
{
    mysql_query("UPDATE tgt_posthands SET title = '$title', hand = '$hand', thinkingprocess = '$thinkingprocess', image1 = '$image', id_class= '$class' WHERE id = '$id'");
    #echo mysql_errno($conexao) . "." . mysql_error($conexao);
    if(mysql_affected_rows() > 0)
    {
        mysql_close($conexao);
        echo 'ok';
    }else{
        mysql_close($conexao);
        echo "Hand problem, view with administrator";
    }
}else{
    mysql_close($conexao);
    echo $mensagem;
}
?>   
