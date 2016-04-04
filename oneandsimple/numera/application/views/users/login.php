<?php $this->load->view('header')?>
<script>
	$(document).ready(function(){
				
				/*Change language*/
				$(".changelng").click(function(){
					var option = $(this).attr('id');
					if(option!=""){
						$.get('<?php echo base_url();?>users/changelaunguage/'+option, function(data) {
						location.reload();
					       });
					}
				});


		});
	
</script>
<div style="text-align:right;margin-right:20px;"><br/>
	<a href="javascript:void(0);" class="changelng" id="engish"><img src="<?php echo base_url() ?>images/icons/english_flagbig.png" title="English"/></a>
	&nbsp;<a href="javascript:void(0);" class="changelng" id="portugal"><img src="<?php echo base_url() ?>images/icons/portugal_flagbig.png" title="Portugu&#234;s"/></a>
</div>
<div class="login-page">
	<div class="login-logo"><a href="<?php echo base_url()?>"><img src="<?php echo base_url()?>images/logo.png" alt="" /></a></div>
	<div class="login-form">
		<div class="login-top"><?php echo $this->lang->line('login_title');?></div>
		<div class="login-center">
			<div><?php echo $this->session->flashdata('message'); ?> </div>
			<?php $attributes = array('name' => 'login', 'id' => 'login');?>
			
			<?php if(get_cookie('user_name')!=""){
				$cookiesusrname =get_cookie('user_name');	
				$cookiesusrpwd =get_cookie('user_pass');
			}else {
				$cookiesusrname ="";	
				$cookiesusrpwd ="";
				} ?>
			
			<?php echo form_open('users/login',$attributes);?>
				<div>
					<div class="input-div">
						<span><img src="<?php echo base_url()?>images/user.png" alt="Username" /></span>
						<input placeholder="<?php echo $this->lang->line('front_user_name_label');?>" type="text" value="<?php echo $cookiesusrname; ?>" name="username" id="username" class="required"/>
					</div>
					<?php echo form_error('username'); ?>
				</div>
				<div>	
					<div id="input-div" class="input-div"> <span><img src="<?php echo base_url()?>images/pass.png" alt="Password" /></span>
						<input placeholder="<?php echo $this->lang->line('front_user_password_label');?>" type="password" class="required" name="password" value="<?php echo $cookiesusrpwd; ?>"/>
					</div>
					<?php echo form_error('password'); ?>
				</div>
				<div>
					<div class="input-radio"> 
						<input class="radio-input" name="chk_remember_me" type="radio" <?php if(get_cookie('user_name')!=""){ echo 'checked="checked"'; } ?> />
						<small><?php echo $this->lang->line('remember_me');?></small>
						<input value="<?php echo $this->lang->line('sign_in') ?>" class="sign" type="submit" />
					</div>
				</div>
			<?php echo form_close();?>		
		</div>
	</div>
	<div class="forgot-pass">
	  <p><?php echo $this->lang->line('forgot_your_password') ?>, <a href="<?php echo base_url()?>users/forgotPassword"><?php echo $this->lang->line('click_here') ?></a><?php echo $this->lang->line('to_reset_password');?></p>
	  <p class="foo-border"><?php $footertxt = get_adminFooter();
                    if(isset($footertxt->adminFooterTxt) && !empty($footertxt->adminFooterTxt)){
                ?>
                    <?php echo $footertxt->adminFooterTxt ?>
                <?php } else {?>
                    <?php echo date('Y');?> © one and simple 
                <?php } ?></p>
	</div>
</div>
<?php //$this->load->view('footer')?>
