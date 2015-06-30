<?php
include '../includes/allpageaj.php';

if (isset($_SESSION['iduser']))
{
    session_destroy();
}
echo 'ok';

closeDataBase();
?>