<?php
@session_start();

if($_SESSION['lang'] == "english"){
    include('html/services.html'); 
}
else{
    include('html/port_services.html');   
}

?>
