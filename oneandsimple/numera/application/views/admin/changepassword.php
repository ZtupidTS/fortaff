<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2>Change password</h2>
	</div>
	
	<div class="tab-menu">
		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				<div class="tab-content-left">
					<?php $attributes = array('name' => 'changepassword', 'id' => 'changepassword');?>
					<?php echo form_open('admin/changepassword',$attributes);?>
						
						<ul class="tab-field">
							
							<li>
							<span><?php echo form_label('Current Password:', 'userPassword','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_password('userPassword', set_value('userPassword'),'id="userPassword"');?>
								</div>
								<?php echo form_error('userPassword'); ?>
							</li>
							<li><span><?php echo form_label('New Password:', 'newuserPassword','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_password('newuserPassword', set_value('newuserPassword'),'id="newuserPassword"');?>
								</div>
								<?php echo form_error('newuserPassword'); ?>
								
							</li>
							<li><span><?php echo form_label('Confirm Password:', 'confirmPassword','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_password('confirmPassword', set_value('confirmPassword'),'id="confirmPassword"');?>
								</div>
								<?php echo form_error('confirmPassword'); ?>
							</li>
						</ul>
						
						<div class="input-radio">
							<input value="Submit" class="sign" type="submit">
						</div>
					<?php echo form_close();?>	
				</div>
			</div>
		 
		</div>
	</div>
<?php $this->load->view('admin_footer')?>