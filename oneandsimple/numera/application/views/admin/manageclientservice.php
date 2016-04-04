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
					<?php //pr($client_service_detail); ?>
					<?php $attributes = array('name' => 'manageclientservice', 'id' => 'manageclientservice');?>
					<?php echo form_open_multipart("admin/manageclientservice/$clientId",$attributes);?>
						<ul class="tab-field">
							<li>
								<span><?php echo form_label('Service Name:', 'serviceName','class="required"');?></span>
								<div class="input-divs">
								<?php echo form_input('serviceName', @$client_service_detail['serviceName'],'id="serviceName"');?>
								</div>
								<?php echo form_error('serviceName'); ?>
							</li>
							<li>
								<span><?php echo form_label('Description:', 'serviceDescription','class="required"');?></span>
								<div class="input-divs">
								<?php echo form_textarea('serviceDescription', @$client_service_detail['serviceDescription'],'id="serviceDescription"" ');?>
								</div>
								<?php echo form_error('serviceDescription'); ?>
							</li>
							
							<!--<li><span><?php echo form_label('Upload:','serviceUpload','class=""')?></span>
								<?php echo form_upload('serviceUpload','id="serviceUpload"')?>
								<?php echo form_error('serviceUpload');?>
							</li>-->
							
							<li>
								<span><?php echo form_label('Starting Date:','startingDate','class="required"')?></span>
								<div class="example-container">
								      <div class="input-divs">
								      <?php echo form_input('startingDate',@$client_service_detail['startingDate'],'id="startingDate"');?>
								      </div>
								      <pre style="display: none">$('#startingDate').datetimepicker();</pre>
								</div>
								<?php echo form_error('startingDate');?>
							</li>
							<li><span><?php echo form_label('Ending Date:', 'phone','class="required"');?></span>
								 <div class="example-container">
								      <div class="input-divs">
								      <?php echo form_input('endingDate', @$client_service_detail['endingDate'],'id="endingDate"');?>
								      </div>
								      <pre style="display: none">$('#endingDate').datetimepicker();</pre>
								      
								 </div>
								<?php echo form_error('endingDate'); ?>
							</li>
						</ul>
						
						<div class="input-radio">
							    <?php echo form_hidden('clientId', @$clientId,'id="clientId" maxlength="15"');?>
							    <?php echo form_hidden('clientserviceid', @$client_service_detail['id'],'id="clientserviceid" maxlength="15"');?>
							<input value="Submit" class="sign" type="submit" name="btnsubmit">
						</div>
						
					<?php echo form_close();?>	
				</div>
			</div>
		 
		</div>
	</div>
<?php $this->load->view('admin_footer')?>