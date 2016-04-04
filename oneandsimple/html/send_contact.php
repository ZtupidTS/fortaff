<?php
@error_reporting(0);
if(isset($_POST['submit'])){
    if($_POST['name']=='Name'){
        $msg1='Name is empty';
    }else {echo $msg1='';}
    
    if($_POST['number']=="Phone Number "){
        $msg2='Phone number is empty';
    }else{echo $msg2='';}
    
    if($_POST['email']=="E-mail"){
        $msg3='Email number is empty';
    }else{
            $email = $_POST['email']; 
            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
            if (preg_match($regex, $email)) {
              $msg3='';
            } else { 
             $msg3 = $email . " is an invalid email. Please try again.";
            }    
    }
    if($_POST['subject']=='Subject'){
        $msg4='Subject is empty';
    }else {echo $msg4='';}
    
    if($_POST['msg']==''){
        $msg5='Message is empty';
    }else {echo $msg5='';}
   
    if(isset($email))
    {
        $to = 'secretariado@oneandsimple.com';
        //$to = 'brijendra.s@cisinlabs.com';
        $subject = "Contanct Us Enquiry";
        $message = "<div><b>New contact us enquiry: </b><br /><br /><br /><b>Name:</b> ".$_POST['name']."<br /><br /><b>Subject:</b> ".$_POST['subject']."<br /><br /><b>Telephone:</b> ".$_POST['number']."<br /><br /><b>Message:</b> ".nl2br($_POST['msg'])."</div>";
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        $headers .= "From: noreply@oneandsimple.com" . "\r\n" ;
        
        
        $result=mail($to, $subject, $message, $headers);
        if($result){
            $send="Message has been sent";
            
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>One And Simple: MAKE IT ONE. MAKE IT SIMPLE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="oneandsimple.co offers Global financial and administrative outsourcing services. A quality service based in an unique and simple principle. MAKE IT ONE. MAKE IT SIMPLE"  />
<meta name="keywords" content="One And Simple, oneandsimple, Numera, administrative outsourcing services, Global financial, Financial Management, Administrative management, Financial services, Adminsitrative services, Gestão Financeira, Gestão Administrativa, Contabilidade, MAKE IT ONE. MAKE IT SIMPLE" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/font.css" />
<style>
.diverror{ color: red;}    
</style>

</head>

<body>
<div class="body_sub">
  <div class="top_container">
    <div class="logo"><a href="http://oneandsimple.com/"><img src="images/oneandsimple_logo.png" /></a></div>
    <div class="navigation">
      <div class="wrapper">
        <ul class="nav">
          <li><a href="index.php">Home</a>|</li>
          <li><a href="services.php">Services</a>|</li>
          <li><a class="active" href="contact.php">Contact Us</a></li>
        </ul>
        <div class="clear"></div>
      </div>
    </div>
    <div class="wrapper">
      <div class="tele"><a href="lang_select.php?lang=english"><img src="images/english_flagbig.png" /></a> <a href="lang_select.php?lang=port"><img src="images/portugal_flagbig.png" /></a></div>
       <div style="float: right;margin-right: 50px;"><a href="https://www.facebook.com/oneandsimple" title="Facebook" target="_blank"><img src="images/facebook.png" /></a></div>
      <div class="clear"></div>
    </div>
  </div>
  <div class="main_container wrapper">
    <div class="rgt_container">
      <div class="banner"> <img src="images/banner_img.jpg" alt="" />
        <div class="trans_strip">MAKE IT ONE. MAKE IT SIMPLE</div>
      </div>
      <div class="banner_shadow"><img src="images/banner_shadowjpg.png" /></div>
      <div class="container">
        <h1>Contact</h1>
        <div class="form_area">
          <div class="form">
            <div class="contact-inner">
              <form method="post" id="contactus">
                  <p><strong>Please leave your message. We will contact you as soon as possible</strong></p>
                  <label><?php if(isset($send)){ echo '<div style="color:green">'.$send.'</div>' ;}?> </label>
                  <label><?php if(isset($msg1)){ echo "<div class='diverror'>$msg1</div>";} ?></label>
                  <label><?php if(isset($msg2)){ echo "<div class='diverror'>$msg2</div>";} ?></label>
                  <label><?php if(isset($msg3)){ echo "<div class='diverror'>$msg3</div>";} ?></label>
                  <label><?php if(isset($msg4)){ echo "<div class='diverror'>$msg4</div>";} ?></label>
                  <label><?php if(isset($msg5)){ echo "<div class='diverror'>$msg5</div>";} ?></label>
                  <label>
                    <input type="text" onblur="if(this.value=='')this.value='Name';" onfocus="if(this.value=='Name')this.value='';" value="Name" title="Digite para buscar" class="textfield" name="name">
                  </label>
                  <label>
                    <input type="text" onblur="if(this.value=='')this.value='Phone Number ';" onfocus="if(this.value=='Phone Number ')this.value='';" value="Phone Number " title="Digite para buscar" class="textfield" name="number">
                    
                  </label>
                  <label>
                    <input type="text" onblur="if(this.value=='')this.value='E-mail';" onfocus="if(this.value=='E-mail')this.value='';" value="E-mail" title="E-mail" class="textfield" name="email">
                    
                  </label>
                  <label>
                    <input type="text" onblur="if(this.value=='')this.value='Subject';" onfocus="if(this.value=='Subject')this.value='';" value="Subject" title="Subject" class="textfield" name="subject">
                  </label>
                  <label>
                    <textarea type="text" onblur="if(this.value=='')this.value='Messages  ';" onfocus="if(this.value=='Messages  ')this.value='';" value="Messages  " title="Messages" class="textarea" name="msg"></textarea>
                    
                  </label>
                  <label><input type="submit" value="Send Message"  name="submit"  class="send-form "> </label>
              </form>
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="contact_form">
          <div class="contact-right">
            <div class="contact-inner">
              <h2>Please contact us at:</h2>
              <p class="add"><strong>Headquarters:</strong></p>
              <p class="add">Centro de Neg&#243;cios Ideia Atl&#226;ntico, cx 013</p>
              <p class="add">4719-005 Ten&#245;es - Braga</p>
              <p class="add">Portugal </p>
              <p class="add_1"><strong>Lisbon:</strong></p>
              <p class="add">Av. Fontes Pereira de Melo, n&#186; 3 - 10&#186; Esq.</p>
              <p class="add">1050-115 Lisboa</p>
              <p class="add" >Portugal </p>
              <p class="add_1">E-mail: secretariado@oneandsimple.com</p>
              <p class="add">Phone: 00351 938423767<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;00351 939281531</p>
            </div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="footer">
      <div class="foot_links">
        <ul>
          <li><a style="margin-left:0" href="index.php">Home</a>|</li>
          <li><a href="services.php">Services</a>|</li>
          <li><a href="contact.php" class="active">Contact Us</a></li>
        </ul>
        <div class="clear"></div>
      </div>
      <div class="copy">copyright 2013 All rights reserved</div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
