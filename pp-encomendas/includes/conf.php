<?php
#############  Database  #############

//aqui para a produção, que é o uso normal
/*openDataBase("127.0.0.1", "pp", "root", "fafedis");
$_SESSION['include_conf'] = 'C:/xampp/htdocs/pp-encomendas/includes/conf.php';
$_SESSION['include_function'] = 'C:/xampp/htdocs/pp-encomendas/fonction/function.php';*/

//aqui é só para o desenvolvimento
openDataBase("127.0.0.1", "pp_dev", "root", "fafedis");
$_SESSION['include_conf'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/conf.php';
$_SESSION['include_function'] = 'C:/xampp/htdocs/pp-encomendas_dev/fonction/function.php';



#############      envio mail diario   #############




//localização do ficheiro 'gr-guias/mail/class.phpmailer.php'
$_SESSION['locate_file_phpmailer'] = 'C:/xampp/htdocs/pp-encomendas_dev/mail/class.phpmailer.php';

//aqui os dados para o envio do mail diario podem ser preenchidos iguais ao do fornecedor
//o unico ponto é caso tenham um servidor interno de mail como no meu caso

//mail login
$_SESSION['login_mail_send_daily'] ='backup@fafedis.pt';
//mail password
$_SESSION['password_mail_send_daily'] ='backup';
//host do servidor de mail
$_SESSION['host_envio_mail_send_daily'] ='127.0.0.1';
//helo a priori igual ao host
$_SESSION['helo_envio_mail_send_daily'] ='127.0.0.1';
//porta do servidor de envio
$_SESSION['port_envio_mail_send_daily'] = 25;
//endereço mail de quem envia referente ao login associado e preenchido mais em cima
$_SESSION['from_mail_send_daily'] ="backup@fafedis.pt";
//alem do envio ao forncedores meter um mail em copia da loja
//$_SESSION['addcc_mail_send_daily'] ="informatica@fafedis.pt";
//Renomear o nome do mail de envio em 
$_SESSION['setfrom_mail_send_daily'] = 'Encomendas';
//preencher com os mails que pretende que vai em copia o mail
//exemplos: ("mail1" => "test1@fafedis.pt") ou ("mail1" => "test1@fafedis.pt", "mail2" => "test2@fafedis.pt"),.....
$_SESSION['add_cc_mail_send_daily'] = array("mail1" => "informatica@fafedis.pt");
//$_SESSION['add_cc_mail_send_daily'] = array("mail1" => "informatica@fafedis.pt");


//aqui temos de por onde se situa os seguintes ficheiros
$_SESSION['pp_bolo_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_bolo.php';
$_SESSION['pp_cobertura_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_cobertura.php';
$_SESSION['pp_encomendas_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_encomendas.php';
$_SESSION['pp_massa_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_massa.php';
$_SESSION['pp_recheio_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_recheio.php';
$_SESSION['pp_users_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/pp_users.php';
$_SESSION['view_nossosbolos_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas_dev/includes/database/view_nossosbolos.php';
$_SESSION['pp_modif_enc_mail_send_daily'] = 'C:/xampp/htdocs/pp-encomendas/includes/database/pp_modif_encomendas.php';

#############      envio sms   #############



$_SESSION['apikey_sms'] = "3ec8e415ff9b7939513675fd50b0c308b07d8fd9";
$_SESSION['list_sms'] = '25';
$_SESSION['user_sms'] = "informatica@fafedis.pt";
$_SESSION['pass_user_sms'] = "leclercgoi29";
$_SESSION['message_sms'] = "Estimado cliente, O seu aparelho já se encontra reparado, queira logo que possivel deslocar-se a nossa loja para proceder ao seu levantamento. Obrigado.";


//$_SESSION[''] =

?>