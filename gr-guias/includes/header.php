<?php
include 'includes/allpage.php';

//verif login
$now = time(); // Checking the time now when home page starts.
/*if(isset($_SESSION['expire']))
{
    if ($now > $_SESSION['expire'])
    {
        session_destroy();
    }
}*/
if(isset($_SESSION['expire']))
{
	if( $_SESSION['last_activity'] < $now-$_SESSION['expire'] ) 
	{ //have we expired?
	    //redirect to logout.php
	    session_destroy();    
	} else{ //if we haven't expired:
	    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
	}
}

if(isset($_SESSION['username']))
{
    $login = "Sair(" . $_SESSION['username'] . ")";        
}else{
    $login = "Entrar";        
    if(recupera_url() != "gr-guias")
    {
        if(recupera_url() != "index")
        {
            header('Location: index.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- On ouvre la fenêtre à la largeur de l'écran -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guias Reparação</title>
        <!-- Intégration du CSS Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/uploadfile.min.css" rel="stylesheet" >
        <link href="css/jquery-ui.css" rel="stylesheet" >
        <!-- tabelas -->
        <link href="css/jquery.dataTables.css" rel="stylesheet" >
        
        <style type="text/css">
	#loadingmsg {
	      color: black;
	      background: #fff; 
	      padding: 10px;
	      position: fixed;
	      top: 50%;
	      left: 50%;
	      z-index: 100;
	      margin-right: -25%;
	      margin-bottom: -25%;
	}
	#loadingover {
	      background: black;
	      z-index: 99;
	      width: 100%;
	      height: 100%;
	      position: fixed;
	      top: 0;
	      left: 0;
	      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
	      filter: alpha(opacity=80);
	      -moz-opacity: 0.8;
	      -khtml-opacity: 0.8;
	      opacity: 0.8;
	}
	</style>  
        <!-- Intégration de la libraire jQuery -->
        <script src="js/other/jquery-1.11.0.js"></script>
        <script src="js/other/jquery-ui.js"></script>
        <script src="js/other/jquery.dataTables.min.js"></script>
        
        <!-- Intégration de la libraire de composants du Bootstrap -->
        <script src="js/other/bootstrap.js"></script>
        <!-- Meus scripts -->
        <script src="js/login.js"></script>
        <script src="js/viewgr.js"></script>
        <!-- for ie8 for bootstrap -->
        <script src="js/other/respond.js"></script>
        <script src="js/html5shiv.js"></script>
        <!-- sript for trim in ie8 -->
        <script src="js/trim.js"></script>
        <script>
       	function showLoading() 
       	{
	    document.getElementById('loadingmsg').style.display = 'block';
	    document.getElementById('loadingover').style.display = 'block';
	}
	function hideLoading() 
       	{
	    document.getElementById('loadingmsg').style.display = 'none';
	    document.getElementById('loadingover').style.display = 'none';
	}
        </script>
        <!-- para o file upload -->
        <script src="js/other/jquery.uploadfile.js"></script>
        <!-- script para ver um pouco da guia -->
        <script src="js/viewDataGr.js"></script>
        <script src="js/viewDataRep.js"></script>
        
        
    </head>
    
    <body>
        <!-- Conteneur principal -->
        <!-- 
        Deux classes sont à connaitre avec Bootstrap pour utiliser la grille, tout d'abord .row, 
        qui représente une ligne, et .span, de .span 1 à .span12, pour définir le nombre de colonnes 
        utilisées sur une meme ligne.
        -->
        <div class="container">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
<!--                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>-->
                    <!-- entrar ou sair -->  
                    <a class="navbar-brand" href="#" onclick="Logout()"><?php echo $login;?></a>
                  </div>
                         <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php if($login != "Entrar"){ ?>
<!--                        <li><a href="#">Início</a></li>-->
	                        <li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Guias de Reparações<b class="caret"></b></a>
	                            <ul class="dropdown-menu">
	                              <li><a href="searchgr.php">Procurar</a></li>
	                              <li><a href="insertgr.php">Inserir</a></li>
	                              <li class="divider"></li>
	                              <li><a href="insertgrcopy.php">Inserir a Copiar de Outra Guia</a></li>
	                              <li class="divider"></li>
	                              <li><a href="anextalao.php">Anexar Talão a guia</a></li>
	                              <li><a href="anexguia.php">Anexar Guia de Entregue a Guia</a></li>
	                              <li class="divider"></li>
	                              <li><a href="modifgr.php">Alterações</a></li>
	                              <li class="divider"></li>
	                              <li><a href="searchgr_archive.php">Procurar no Arquivo</a></li>
	                            </ul>
	                        </li>
	                        <li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reparadores<b class="caret"></b></a>
	                            <ul class="dropdown-menu">
	                              <li><a href="searchreparador.php">Consultar</a></li>
	                              <li><a href="insertrep.php">Inserir</a></li>
	                              <li class="divider"></li>
	                              <li><a href="modifreparador.php">Alterações</a></li>
	                              <li class="divider"></li>
	                              <li><a href="deleterep.php">Eliminar</a></li>
	                            </ul>
	                        </li>
	                        <li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tarefas<b class="caret"></b></a>
	                            <ul class="dropdown-menu">
	                              <li><a href="sendmail.php">Enviar Mail ao Reparador</a></li>                              
	                              <li><a href="levantamentogr.php">Registar Levantamento Pelo Reparador</a></li>
	                              <li class="divider"></li>
	                              <li><a href="sendmailanexo.php">Enviar Mail Com Anexo ao Reparador</a></li>
	                              <li class="divider"></li>
	                              <li><a href="sendsms.php">Enviar SMS ao Cliente</a></li>
	                              <li><a href="entregueclgr.php">Registar Levantamento Pelo Cliente</a></li>
	                              <li><a href="verifystatussms.php">Verificar estado SMS</a></li>
	                              <li class="divider"></li>
	                              <li><a href="orcamento.php">Inserir valor Orçamento</a></li>   
	                              <li class="divider"></li>
	                              <li><a href="closegr.php">Fechar Guia</a></li>                          
	                            </ul>
	                        </li>
	                        <li class="dropdown">
	                        	<?php 
	                        	if($_SESSION['username'] != "Admin")
	                        	{?>
						<a href="adminlogin.php">Admin</a>
						<?php
					}?>
	                        	
	                        </li>
	                        <?php
	                        	if($_SESSION['username'] == "Admin")
	                        	{?>
						<li class="dropdown">
			                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administração<b class="caret"></b></a>
			                            <ul class="dropdown-menu">
			                              <li><a href="deletegr.php">Eliminar guia</a></li>
			                              <li><a href="recupgr.php">Recuperar Guia</a></li>
			                              <li class="divider"></li>
			                              <li><a href="adduser.php">Adicionar funcionario</a></li>
			                              <li><a href="deluser.php">Desativar funcionario</a></li>
			                              <li><a href="activeuser.php">Reactivar funcionario</a></li>
			                              <li class="divider"></li>
			                              <li><a href="addsection.php">Adicionar Secção</a></li>
			                              <li><a href="delsection.php">Desactivar Secção</a></li>	                              
			                            </ul>
			                        </li>
			                        <?php 
			        	}?>
			       	<li class="dropdown">
	                        	<a href="info.php">Info</a>				
	                        </li>                     
                       	<?php } ?>
                      	
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><img src="images/eleclerc.jpg" height="25" width="130" hspace="1" style="margin:0px"></a></li>
<!--                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Separated link</a></li>
                        </ul>
                      </li>-->
                    </ul>
                  </div><!-- /.navbar-collapse -->
                  
                </div><!-- /.container-fluid -->
            </nav>
