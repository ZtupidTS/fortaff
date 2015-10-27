<?php
#############  Database  #############

//aqui para a produção, que é o uso normal
/*openDataBase("127.0.0.1", "gr", "root", "fafedis");
$_SESSION['include_conf'] = 'C:/xampp/htdocs/gr-guias/includes/conf.php';
$_SESSION['include_function'] = 'C:/xampp/htdocs/gr-guias/fonction/function.php';*/

//aqui é só para o desenvolvimento
openDataBase("127.0.0.1", "grdev", "root", "fafedis");
$_SESSION['include_conf'] = 'C:/xampp/htdocs/gr-guias_dev/includes/conf.php';
$_SESSION['include_function'] = 'C:/xampp/htdocs/gr-guias_dev/fonction/function.php';



#############       enviar mail para o fornecedor  #############



//mail login
$_SESSION['login_mail_send_supplier'] ='bazarsav@fafedis.pt';
//mail password
$_SESSION['password_mail_send_supplier'] ='1Qqz%2o8';
//host do servidor de mail
$_SESSION['host_envio_mail_send_supplier'] ='mail.fafedis.pt';
//helo a priori igual ao host
$_SESSION['helo_envio_mail_send_supplier'] ='mail.fafedis.pt';
//porta do servidor de envio
$_SESSION['port_envio_mail_send_supplier'] = 25;
//endereço mail de quem envia referente ao login associado e preenchido mais em cima
$_SESSION['from_mail_send_supplier'] ="bazarsav@fafedis.pt";
//alem do envio ao forncedores meter um mail em copia da loja
//$_SESSION['addcc_mail_send_supplier'] ="bazarsav@fafedis.pt";
$_SESSION['addcc_mail_send_supplier'] ="gravenegro@gmail.com";
//Renomear o nome do mail de envio em 
$_SESSION['setfrom_mail_send_supplier'] = 'Bazar SAV';
//o corpo do mail
//existe 2 corpos, um para o levantamento e outro para a reparação em casa do cliente
//levantamento
$_SESSION['corpo_levantamento_mail_send_supplier'] = 'Venho por este meio pedir o levantamento do artigo relativo a guia em anexo.';
//em casa do cliente
$_SESSION['corpo_casa_mail_send_supplier'] = 'Venho por este meio solicitar a reparação ao domicílio da guia em anexo.';
//Podem acrescentar um pequeno texto que vai ser enviado no corpo do mail
//Caso não querem acrescentar é deixar assim ''
$_SESSION['corpo_add_body'] = '';



#############      criação do pdf     #############




//morada
$_SESSION['morada_leclerc_pdf'] = 'Campo Do Lameiro - Lugar de Sto. Ovídeo';
//codigo postal
$_SESSION['cod_postal_leclerc_pdf'] = '4820-178 Fafe';
//telefone
$_SESSION['telefone_leclerc_pdf'] = '253 509 160';
//fax
$_SESSION['fax_leclerc_pdf'] = '253 509 189';
//mail no cabeçalho da guia
$_SESSION['mail_leclerc_pdf'] = 'bazarsav@fafedis.pt';
//nif
$_SESSION['nif_leclerc_pdf'] = '507019792';

//update v1.1
//anotação no rodapé (só na guia do cliente), não obrigatorio, podem deixar em branco ao deixar assim ''.
$_SESSION['rodape_guia'] = 'NOTA - O PRAZO MAXIMO DE REPARAÇÃO SÃO 30 DIAS ÚTEIS A CONTAR A PARTIR DA DATA DE ENTRADA NA LOJA. ESTA GUIA É INDISPENSÁVEL
PARA O LEVANTAMENTO DO SEU ARTIGO EM LOJA, SE NÃO APRESENTA-LA NÃO PODERA LEVANTAR O ARTIGO EM CAUSA.';
//tamanho da letra do rodape de 4 a 7
$_SESSION['size_font_rodape'] = 7;




#############      envio mail diario   #############




//localização do ficheiro 'gr-guias/mail/class.phpmailer.php'
$_SESSION['locate_file_phpmailer'] = 'C:/xampp/htdocs/gr-guias/mail/class.phpmailer.php';

//aqui os dados para o envio do mail diario podem ser preenchidos iguais ao do fornecedor
//o unico ponto é caso tenham um servidor interno de mail como no meu caso

//mail login
$_SESSION['login_mail_send_daily'] ='bazarsav@fafedis.pt';
//mail password
$_SESSION['password_mail_send_daily'] ='bazarsavfafe';
//host do servidor de mail
$_SESSION['host_envio_mail_send_daily'] ='127.0.0.1';
//helo a priori igual ao host
$_SESSION['helo_envio_mail_send_daily'] ='127.0.0.1';
//porta do servidor de envio
$_SESSION['port_envio_mail_send_daily'] = 25;
//endereço mail de quem envia referente ao login associado e preenchido mais em cima
$_SESSION['from_mail_send_daily'] ="bazarsav@fafedis.pt";
//alem do envio ao forncedores meter um mail em copia da loja
//$_SESSION['addcc_mail_send_daily'] ="informatica@fafedis.pt";
//Renomear o nome do mail de envio em 
$_SESSION['setfrom_mail_send_daily'] = 'Bazar SAV';
//preencher com os mails que pretende que vai em copia o mail
//exemplos: ("mail1" => "test1@fafedis.pt") ou ("mail1" => "test1@fafedis.pt", "mail2" => "test2@fafedis.pt"),.....
//$_SESSION['add_cc_mail_send_daily'] = array("mail1" => "informatica@fafedis.pt", "mail2" => "bazarl@fafedis.pt", "mail3" => "bazarl2@fafedis.pt", "mail4" => "bazarp@fafedis.pt", "mail5" => "bazarsav@fafedis.pt" );
$_SESSION['add_cc_mail_send_daily'] = array("mail1" => "informatica@fafedis.pt");

//aqui temos de por onde se situa os seguintes ficheiros
$_SESSION['mysql_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/mysql.php';
$_SESSION['dblogin_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dblogin.php';
$_SESSION['dbgrep_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dbgrep.php';
$_SESSION['dbmodifgr_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dbmodifgr.php';
$_SESSION['dbmodifreparador_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dbmodifreparador.php';
$_SESSION['dbreparador_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dbreparador.php';
//update v1.2
$_SESSION['dbsection_mail_send_daily'] = 'C:/xampp/htdocs/gr-guias/includes/database/dbsection.php';




#############      envio sms   #############



$_SESSION['apikey_sms'] = "3ec8e415ff9b7939513675fd50b0c308b07d8fd9";
$_SESSION['list_sms'] = '25';
$_SESSION['user_sms'] = "informatica@fafedis.pt";
$_SESSION['pass_user_sms'] = "leclercgoi29";
$_SESSION['message_sms'] = "Estimado cliente, O seu aparelho já se encontra reparado, queira logo que possivel deslocar-se a nossa loja para proceder ao seu levantamento. Obrigado.";



#############      configuração da aplicação   #############

//aqui é inserido o numero a partir do qual deve se arquivar as guias
// 60 = acima de 60 dias aparece no menu guias arquivadas
// Caso não queira usar essa opção deixar assim ''
$_SESSION['archive_gr'] = '90'

?>