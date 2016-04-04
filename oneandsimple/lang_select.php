<?php
@session_start();
if($_GET['lang'] == "english"){
    $_SESSION['lang'] = 'english';	
    
}
else{
    $_SESSION['lang'] = 'port'; 
}

header('Location: '.$_SERVER['HTTP_REFERER']);
exit;
?>
