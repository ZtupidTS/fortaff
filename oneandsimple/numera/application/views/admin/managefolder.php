<?php $this->load->view('admin_header')?>

<!--Get client folders on change select box-->

     <div class="headind">
	     <h2><?php echo $title; ?></h2>
		<?php if($this->uri->segment(3) && @$userId){?>
			<span class="admin-right-menu">
				<!--<a href="<?php echo site_url();?>admin/setpermission/<?php echo $this->uri->segment(3);?>">Set permissions </a><a>|</a>-->
				<a href="<?php echo site_url();?>admin/adduser/<?php echo $this->uri->segment(3);?>">Add User </a>
				<!--<a>|</a><a href="<?php echo site_url();?>admin/manageclientservice/<?php echo $this->uri->segment(3);?>">Add Service </a><a>|</a>-->
				<!--<a href="<?php echo site_url();?>admin/managecontactperson/<?php echo $this->uri->segment(3);?>">Add contact person</a>-->
			</span>
		<?php } ?>	
     </div>
	
     <div class="tab-menu">
	  <div class="tab-content"></br>
	       <?php echo $this->session->flashdata('message'); ?>
		<br/>
	       <?php //pre($folderDetail); ?>
	       <?php $attributes = array('name' => 'managefolder', 'id' => 'managefolder');?>
	       <?php echo form_open_multipart("admin/managefolder/".$this->uri->segment(3),$attributes);?>
	       <div class="main-tab">
			 <div class="tab-content-left">			      
				   <ul class="tab-field">
					<?php //if(@$folderDetail[0]['parentId']!=0 && @$folderDetail[0]['id']==null ){ ?>
					<li>
						 <span><?php echo form_label('Parent Folder :', 'parentfolderid','class="required"');?><em>*</em></span>
						 <div class="input-divs">
							<?php if($this->uri->segment(3) && @$folderDetail[0]['id']){?>
								<div style="margin-top: 8px;">
									<?php if(@$folderDetail['parentfolder'][0]['folderName']==''){?> Parent folder<?php }else{?>
										<?php echo @$folderDetail['parentfolder'][0]['folderName']; ?>
										<input type="hidden" value="<?php echo @$folderDetail['parentfolder'][0]['userId']; ?>" name="redirectfolderid"/>
	
									<?php } ?>
								</div>
							<?php } else {?>
								<select name="parentfolderid" id="clientid" class="select required" >
								     <option value = "">- Select -</option>
								     <?php echo $userfoldersoption ?>
								     <!--<?php if(isset($foder_array)){
									  foreach($foder_array as $val)
									  {?>
									  
									       <option value = "<?php echo $val['id']; ?>" <?php if($val['id']==@$folderDetail[0]['parentId']){ echo "selected";} ?>>	<?php echo $val['folderName'];?></option>
									  
								     <?php } }?>-->
								</select>
								<input type="hidden" value="<?php echo $this->uri->segment(3); ?>" name="redirectfolderid"/>

							<?php }?>
						 </div>
						 <?php echo form_error('parentfolderid'); ?>
					</li>
					<?php //} ?>
					 <li>
						 <span><?php echo form_label('Name:', 'folderName','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('folderName', @$folderDetail[0]['folderName'],'id="folderName"');?>
						 </div>
						 <?php echo form_error('folderName'); ?>
						 <div id="usererror"></div>
					</li>
					 
				   </ul>
			 </div>
			 <div class="tab-content-left2"></div>
	       </div>
	       <div class="input-radio" style="float:left">
		    <input type="hidden"  name="id" value="<?php echo @$folderDetail[0]['id'];?>" id="id">
		    <input value="Submit" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
	       </div>
	       <?php echo form_close();?>		
		 
		</div>
	</div>
<?php $this->load->view('admin_footer')?>