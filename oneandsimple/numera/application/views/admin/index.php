<?php $this->load->view('admin_header')?>
<div class="login-page">
	<div class="login-logo"><a href="#"><img src="<?php echo base_url()?>images/logo.png" alt="" /></a></div>
	<div class="login-form">
		<div class="login-top"><?php echo $this->lang->line('admin_login_title');?></div>
		<div class="login-center">
			<div><?php echo $this->session->flashdata('message'); ?> </div>
			
			<?php if(get_cookie('admin_name')!=""){
				$cookiesusrname =get_cookie('admin_name');	
				$cookiesusrpwd =get_cookie('admin_pass');
			}else {
				$cookiesusrname ="";	
				$cookiesusrpwd ="";
				} ?>
			<?php $attributes = array('name' => 'login', 'id' => 'login');?>
			<?php echo form_open('admin',$attributes);?>
				<div>
					<div class="input-div">
						<span><img src="<?php echo base_url()?>images/user.png" alt="Username" /></span>
						<input placeholder="Username" type="text" name="username" value="<?php echo $cookiesusrname; ?>" id="username" class="required" style="text-align:left"/>
					</div>
					<?php echo form_error('username'); ?>
				</div>
				<div>	
					<div id="input-div" class="input-div"> <span><img src="<?php echo base_url()?>images/pass.png" alt="Password"  /></span>
						<input placeholder="Password" type="password" value="<?php echo $cookiesusrpwd; ?>" class="required" name="password" style="text-align:left"/>
					</div>
					<?php echo form_error('password'); ?>
				</div>
				<div>
					<div class="input-radio">
						<input class="radio-input" name="chk_remember_me" type="radio" <?php echo ((($this->input->cookie('admin_name') != "") && ($this->input->cookie('admin_pass') != "")) ? "checked='yes'" : "No"); ?> />
						<small><?php echo $this->lang->line('remember_me');?></small>
						<input value="<?php echo $this->lang->line('sign_in') ?>" class="sign" type="submit" />
					</div>
				</div>
			<?php echo form_close();?>		
		</div>
	</div>
	<div class="forgot-pass">
	  <p><?php echo $this->lang->line('forgot_your_password') ?> <a href="<?php echo base_url()?>admin/forgotepassword"><?php echo $this->lang->line('click_here') ?> </a><?php echo $this->lang->line('to_reset_password');?></p>
	  <p class="foo-border"><?php $footertxt = get_adminFooter();
                    if(isset($footertxt->adminFooterTxt) && !empty($footertxt->adminFooterTxt)){
                ?>
                    <?php echo $footertxt->adminFooterTxt ?>
                <?php } else {?>
                    <?php echo date('Y');?> � one and simple 
                <?php } ?></p>
	</div>
</div>
<?php $this->load->view('admin_footer')?>
