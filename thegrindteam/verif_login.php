<?php
session_start();

include 'includes/connectDB.php';
include 'fonction/fonction.php';
$login = control_post($_POST['login']);
$password = control_post($_POST['password']);

$db = mysql_query("SELECT * FROM tgt_users WHERE login = '$login' and password = '$password'");
if(mysql_num_rows($db) < 1)
{
    mysql_close($conexao);
    $_SESSION['mensagem'] = 'Login ou mot de passe erronn?e';
    header('Location: index.php');
}else{
    $dados = mysql_fetch_array($db);
    if($dados['enable'] == 0)
    {
        mysql_close($conexao);
        $_SESSION['mensagem'] = 'Utilisateur desactive';
        header('Location: index.php');
    }else{
        mysql_close($conexao);
        $_SESSION['login'] = true;
        #D?finition du cookie#
        $cookie = $login;
        $cookie .= '||'. $password;
        #D?finition du temps d'expiration du cookie#
        $time = time() + 3600 * 24 * 360; // Expire dans un an
        #Envoi du cookie#
        setcookie('login_thegrindteam', $cookie, $time);
        $_SESSION['name'] = $login;
        $_SESSION['id_users'] = $dados['id'];
        header('Location: global.php');
    }
}
?>

