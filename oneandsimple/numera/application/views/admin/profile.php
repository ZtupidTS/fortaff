<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	</div>
	
	<div class="tab-menu">
		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				<div class="tab-content-left">
					<?php //pr($adminDetails); ?>
					<?php $attributes = array('name' => 'register', 'id' => 'adminprofile');?>
					<?php echo form_open_multipart('admin/manageadmin',$attributes);?>
						<ul class="tab-field">
							<li>
								<span><?php echo form_label('User Name:', 'userName','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('userName', @$adminDetails['userName'],'id="userName"');?>
								</div>
								<?php echo form_error('userName'); ?>
							</li>
							<li>
								<span><?php echo form_label('Email:','userEmail','class="required"')?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('userEmail',@$adminDetails['userEmail'],'id="userEmail"');?>
								</div>
								<?php echo form_error('userEmail');?>
							</li>
							<li><span><?php echo form_label('Phone:', 'userPhone','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('userPhone', @$adminDetails['userPhone'],'id="userPhone" maxlength="15"');?>
								</div>
								<?php echo form_error('userPhone'); ?>
							</li>
							
							<li><span><?php echo form_label('Footer text:', 'adminFooterTxt','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('adminFooterTxt',@$adminDetails['adminFooterTxt'],'id="adminFooterTxt"');?>
								</div>
								<?php echo form_error('adminFooterTxt'); ?>
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