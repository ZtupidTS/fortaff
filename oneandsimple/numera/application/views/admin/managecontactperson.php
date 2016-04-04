<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2><?php echo $title; ?></h2>
	     <?php if($this->uri->segment(3) && $clientId){?>
			<span class="admin-right-menu">
				<a href="<?php echo site_url();?>admin/manageclientservice/<?php echo $this->uri->segment(3);?>">Add Service </a><a>|</a>
				<a href="<?php echo site_url();?>admin/managecontactperson/<?php echo $this->uri->segment(3);?>">Add contact person</a>
			</span>
	       <?php } ?>	
	     
	</div>
	
	<div class="tab-menu">
		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				<div class="tab-content-left">
					<?php //pr($contact_person_detail); ?>
					<?php $attributes = array('name' => 'savecontactperson', 'id' => 'savecontactperson');?>
					<?php echo form_open_multipart("admin/managecontactperson/$clientId",$attributes);?>
						<ul class="tab-field">
							<li>
								<span><?php echo form_label('Person Name:', 'name','class="required"');?></span>
								<div class="input-divs">
								<?php echo form_input('name', @$contact_person_detail['name'],'id="name"');?>
								</div>
								<?php echo form_error('name'); ?>
							</li>
							<li>
								<span><?php echo form_label('Profession:', 'profession','class="required"');?></span>
								<div class="input-divs">
								<?php echo form_input('profession', @$contact_person_detail['profession'],'id="profession"');?>
								</div>
								<?php echo form_error('profession'); ?>
							</li>
							<li>
								<span><?php echo form_label('Email:','email','class="required"')?></span>
								<div class="input-divs">
								<?php echo form_input('email',@$contact_person_detail['email'],'id="email"');?>
								</div>
								<?php echo form_error('email');?>
							</li>
							<li><span><?php echo form_label('Phone:', 'phone','class="required"');?></span>
								<div class="input-divs">
								<?php echo form_input('phone', @$contact_person_detail['phone'],'id="phone" maxlength="15"');?>
								</div>
								<?php echo form_error('phone'); ?>
							</li>
						</ul>
						
						<div class="input-radio">
							    <?php echo form_hidden('clientId', @$clientId,'id="clientId" maxlength="15"');?>
							    <?php echo form_hidden('contactpid', @$contact_person_detail['id'],'id="contactpid" maxlength="15"');?>
							<input value="Submit" class="sign" type="submit" name="btnsubmit">
						</div>
					<?php echo form_close();?>	
				</div>
			</div>
		 
		</div>
	</div>
<?php $this->load->view('admin_footer')?>