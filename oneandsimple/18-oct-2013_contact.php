<?php
@session_start();

if($_SESSION['lang'] == "english"){
include('send_contact.php');    

}
else{
    include('port_send_contact.php');    
}

?>
