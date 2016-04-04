<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Home</title>
<link href="<?php echo base_url();?>css/admin_css/admin_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url();?>css/admin_css/jquery-ui-timepicker-addon.css" />

<!--<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-1.6.1.min.js"></script>-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.validate-rules.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/common.js"></script>
<?php if($this->session->userdata('loggedInAdmin')) {?>
		<script type="text/javascript">
		
			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;
					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}
			$(function() {
				var dd = new DropDown( $('#dd') );
				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-5').removeClass('active');
				});
			});
		</script>
<?php } else{ ?>
	<script type="text/javascript" src="<?php echo base_url();?>javascript/placeholder.js"></script>
<?php } ?>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-ui-timepicker-addon.js"></script>


</head>
<body>
<div class="wrapper">
	<?php if($this->session->userdata('loggedInAdmin')) {?>
		<?php //pr($this->session->userdata); ?>
		<div class="header">
		    <div class="logo"><a href="<?php echo base_url();?>admin"><img src="<?php echo base_url();?>images/logo-inner.png" alt="" /></a></div>
		    <div class="header-right">
		      <div class="wrapper-demo">
			<div id="dd" class="wrapper-dropdown-5" tabindex="1"><span><?php if($this->session->userdata('admin_name')=='admin'){ echo ucfirst($this->session->userdata('admin_name'));}?></span> <img src="<?php echo base_url();?>images/admin-big.png" alt="" />
			  <ul class="dropdown">
			    <li><a href="<?php echo base_url();?>admin/editprofile"><i class="icon-user"></i>Profile</a></li>
			    <li><a href="<?php echo base_url();?>admin/changepassword"><i class="icon-cog"></i>Change password</a></li>
			    <li><a href="<?php echo base_url();?>admin/logout"><i class="icon-remove"></i>Log out</a></li>
			  </ul>
			</div>
			</div>
		    </div>
		  </div>
		  <?php if($this->uri->segment(2)=='dashboard'){ $minheight="min-height: 00px;";}else{ $minheight='';}?>
		  <div class="main-contnt" style="<?php echo $minheight ?>">
			<div class="top-menu">
			  <!--<ul>
			    <li><a href="<?php echo base_url();?>admin"><img title="Home" src="<?php echo base_url();?>images/home.png" alt="home" /></a></li>
			    <li><a href="javascript:history.go(-1)"><img title="Back" src="<?php echo base_url();?>images/back.png" alt="back" /></a></li>
			  </ul>-->
				<div class="menu-left" style="">
					<a href="<?php echo base_url();?>admin" <?php if(@$menu==1){ echo 'class="adminactive"';}?> >Home</a>
					<a href="<?php echo base_url();?>admin/clients" <?php if(@$menu==4){ echo 'class="adminactive"';}?> >Clients</a>
					<a href="<?php echo base_url();?>admin/users" <?php if(@$menu==2){ echo 'class="adminactive"';}?> >Users</a>
					<a href="<?php echo base_url();?>admin/editprofile" <?php if(@$menu==7){ echo 'class="adminactive"';}?>>My Profile</a>
					<!--<a href="<?php echo base_url();?>admin/changepassword" <?php if(@$menu==6){ echo 'class="adminactive"';}?>>Change Password</a>-->
					<a href="<?php echo base_url();?>admin/updatenumeraemail" <?php if(@$menu==8){ echo 'class="adminactive"';}?>>Change Numera Email</a>
					<a href="<?php echo base_url();?>admin/messagebox" <?php if(@$menu==9){ echo 'class="adminactive"';}?>>Message</a>
					<a href="<?php echo base_url();?>admin/logout">Logout</a>
				  <!--</ul>-->
				</div>
				<div style="float:right">Welcome to Administration section</div>
			</div>
			
			<div class="section">
					<?php if(@$menu==9){?>
                            <div class="msg-menu">
			        <a href="<?php echo base_url();?>admin/messagebox" <?php if(@$submenu=='9a'){ echo 'class="adminactive"';}?>>Messagebox</a>
				    <!--a href="<?php echo base_url();?>admin/messageOutbox" <?php if(@$submenu=='9b'){ echo 'class="adminactive"';}?>>Outbox</a-->
				    <a href="<?php echo base_url();?>admin/composeMessage" <?php if(@$submenu=='9c'){ echo 'class="adminactive"';}?>>Compose</a>
                            </div>
				    <?php } ?>
				<!--<div class="section-left">
				  <ul class="left-menu">
				    <li><a href="<?php echo base_url();?>admin/users">Users</a></li>
				    <li><a href="<?php echo base_url();?>admin/clients">Client</a></li>
				     <li><a href="<?php echo base_url();?>admin/editprofile">My Profile</a></li>
				      <li><a href="<?php echo base_url();?>admin/changepassword">Change Password</a></li>
				      <li><a href="<?php echo base_url();?>admin/logout">Logout</a></li>
				  </ul>
				</div>-->
				<div class="section-right">
	<?php } ?>	  
	
