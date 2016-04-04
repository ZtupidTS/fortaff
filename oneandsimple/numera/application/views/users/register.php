<?php $this->load->view('header')?>
<div id="bodytopmainPan">
<div id="bodytopPan">
	<h2>Please Register</h2>
	<p>
		<form id="register" accept="<?php echo base_url()?>user/submitUser" enctype="multipart/form-data" method="post">
		<p>
			<?php echo form_label('Username:', 'username','class="required"');?>
			<?php echo form_input('username', set_value('username'),'id="username"');?>
			<?php echo form_error('username'); ?>
		</p>
		<p>
			<?php echo form_label('Password:', 'password','class="required"');?>
			<?php echo form_password('password');?>
			<?php echo form_error('password'); ?>
		</p>
		<p>
			<?php echo form_label('Email:','email','class="required"')?>
			<?php echo form_input('email',set_value('email'),'id="email"');?>
			<?php echo form_error('email');?>
		</p>
		<p>
			<?php echo form_label('Gender:','gender','class="required"')?>
			<?php echo form_radio('gender', 'male'). " Male";?>
			<?php echo form_radio('gender', 'female'). " Female";?>
			<?php echo form_error('gender');?>
		</p>
		<p>
			<?php echo form_label('Image:','image','class="required"')?>
			<?php echo form_upload('image','id="image"')?>
			<?php echo form_error('image');?>
		</p>
		<p>
			<?php 	echo form_label('State:','gender','class="required"')?>
			<?php $options=array(''=>'Select','1'=>'India','2'=>'USA'); ?>
			<?php echo form_dropdown('state', $options, $this->input->post('state'));?>
			<?php echo form_error('state');?>
		</p>
		<p>
			<?php echo form_label('Terms:','terms','class="required"')?>
			<?php echo form_checkbox('terms', 'yes');?>
			<?php echo form_error('terms');?>
		</p>
		<p>
			<?php echo form_submit('submitLogin','Submit')?>
			<?php echo form_reset('resetLogin','Reset')?>
		</p>
		<?php echo form_close();?>
		<?php echo anchor('user/','Login')?>
	</p>	
</div>
</div>
<?php $this->load->view('footer')?>
