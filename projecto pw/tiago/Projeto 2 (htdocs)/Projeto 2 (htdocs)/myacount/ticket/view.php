<html>
<head>
<title>SIGO - Ticket</title>
<style media="all" type="text/css">
        table td {
            border-collapse: collapse;
        }
</style>
</head>
<body marginheight="0">
	<br>
	<center>
		<table width="550" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="455">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 0px solid #dddddd; background-image:url(http://pw606.x10.mx/pw606/img/ticket.png); background-repeat: no-repeat">
						<tr>
						  <td height="76" colspan="2" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;">
                            <p><br/>
                              <br/>
                            </p>                          
						  <td width="56%" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;"><strong>Nome do Utilizador:</strong>
<?= $_POST['nome'] ?>
                            <br/>
                            <strong>Email:</strong>
<?= $_POST['email'] ?>                          
						  <td width="8%" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;">                          
			    <td width="9%" rowspan="3" align="center" valign="middle" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px; writing-mode: tb-rl;
filter: flipv fliph;"></tr>
						<tr>
						  <td height="84" colspan="3" align="center" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:15px; font-weight:normal; color:#ffffff; padding:15px;"><b><?= $_POST['acontecimento'] ?></b>
					      :
                            <?= $_POST['evento'] ?>
                            <br/>
<b>Local:</b>
<?= $_POST['local'] ?>
<br/>
<b>Tipo:</b>
<?= $_POST['tipo'] ?>                          
						  <td height="84" align="center" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#ffffff; padding:15px;">                                                    
                </tr>
						<tr>
						  <td width="11%" height="84" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;">                          
						  <td height="84" colspan="2" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;">                          <strong>Quantidade:</strong>
<?= $_POST['quantidade'] ?>
bilhete(s)<br/>
<strong>Pre&ccedil;o:</strong>
<?= $_POST['preco'] ?>
&euro;<br/>
<b>Total:</b>
<?= $_POST['total'] ?>
&euro;                          
						  <td height="84" align="left" valign="top" style="font-family:Lucida Sans Unicode,Lucida Grande,sans-serif;font-size:12px; font-weight:normal; color:#666666; padding:15px;">                          
		        </tr>
					</table>
				</td>
			</tr>
		</table>
</center>
		<br>
</body>
</html>