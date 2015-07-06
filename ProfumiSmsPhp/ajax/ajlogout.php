<?php
include '../includes/allpage.php';

if (isset($_SESSION['iduser']))
{
    session_destroy();
}
echo 'ok';

closeDataBase();
?>