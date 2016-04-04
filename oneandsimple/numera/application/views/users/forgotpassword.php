<?php $this->load->view('header')?>

<div class="login-page">
	<div class="login-logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>images/logo.png" alt="" /></a></div>
	<div class="login-form">
		<div class="login-top"><?php echo $this->lang->line('forgot_password_label');?></div>
		<div class="login-center">
			<?php $attributes = array('name' => 'forgotpassword', 'id' => 'forgotpassword');?>
			<?php echo form_open('users/forgotPassword',$attributes);?>
				<div><?php echo $this->session->flashdata('message'); ?> </div>
				<div>
					<div class="input-div">
						<span><img src="<?php echo base_url()?>images/user.png" alt="Username" /></span>
						<input placeholder="Email" type="text" name="email" id="email" class="required"/>
					</div>
					<?php echo form_error('email'); ?>
				</div>				
				<div><div class="input-radio"><input value="Send" class="sign" type="submit" /></div></div>
			<?php echo form_close();?>		
		</div>
	</div>
	<div class="forgot-pass">
	  <p><?php echo $this->lang->line('if_know_label');?><a href="<?php echo base_url()?>users"><?php echo $this->lang->line('login_here_label');?></a>.</p>
	  <p class="foo-border">2013 &#169; Numera, <?php echo $this->lang->line('power_by_label');?> one and simple</p>
	</div>
</div>
<?php $this->load->view('footer')?>
