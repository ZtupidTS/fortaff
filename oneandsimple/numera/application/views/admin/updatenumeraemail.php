<?php $this->load->view('admin_header')?>
	<div class="headind">
	     <h2>Change Numera Email Account</h2>
	</div>
	
	<div class="tab-menu">
		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
			<div class="main-tab">
				<div class="tab-content-left">
					<?php $attributes = array('name' => 'updatenumeraemail', 'id' => 'updatenumeraemail');?>
					<?php echo form_open('admin/updatenumeraemail',$attributes);?>
						
						<ul class="tab-field">
							
							<li>
							<span><?php echo form_label('Numera Email :', 'numeraEmail','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('numeraEmail', @$numeraEmailDetail['numeraEmail'],'id="numeraEmail"');?>
								</div>
								<?php echo form_error('numeraEmail'); ?>
							</li>
							<li><span><?php echo form_label('Password:', 'numeraPassword','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_password('numeraPassword', @$numeraEmailDetail['numeraPassword'],'id="numeraPassword"');?>
								</div>
								<?php echo form_error('numeraPassword'); ?>
								<input type="hidden" name="numeraEmailId" value="<?php echo @$numeraEmailDetail['id'];?>"/>
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