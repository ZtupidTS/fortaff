<?php
@session_start();

if($_SESSION['lang'] == "english"){
include('html/index.html');    

}
else{
    include('html/port_index.html');    
}

?>
