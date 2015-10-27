<?php
include '../includes/allpageaj.php';

//require('../fpdf/fpdf.php');
//permite criar uma font a partir das font do windows
//require('../fpdf/makefont/makefont.php');
//MakeFont('../fpdf/arial.ttf','iso-8859-1', true);

$id = "";

if(isset($_GET['id']))
{
    //$grepdb = grepGetById($_GET['id']);
    $id = $_GET['id'];
}else{
    //$grepdb = grepGetById($_SESSION['lastidinsert']);
    $id = $_SESSION['lastidinsert'];
}

$pdfnew = createpdfA5($id);
$pdfnew->Output();

unset($id);
unset($_SESSION['lastidinsert']);
unset($_SESSION['lastgr_number']);

closeDataBase();
?>