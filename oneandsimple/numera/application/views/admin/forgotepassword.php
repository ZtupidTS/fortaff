<?php $this->load->view('admin_header')?>

<div class="login-page">
	<div class="login-logo"><a href="<?php echo base_url()?>admin"><img src="<?php echo base_url()?>images/logo.png" alt="" /></a></div>
	<div class="login-form">
		<div class="login-top">Forgot password</div>
		<div class="login-center">
			<?php $attributes = array('name' => 'forgotpassword', 'id' => 'forgotpassword');?>
			<?php echo form_open('admin/forgotepassword',$attributes);?>
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
	  <p>If you know password ? no worries, click to <a href="<?php echo base_url()?>admin">Login here</a>.</p>
	  <p class="foo-border">2013 &#169; Numera, Powered by one and simple</p>
	</div>
</div>
<?php $this->load->view('admin_footer')?>
