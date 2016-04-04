<?php $this->load->view('admin_header')?>
	  <div class="headind">
	       <h2><?php echo $title; ?> <?php echo $username; ?></h2>
	       <span class="admin-right-menu">
		    <a href="<?php echo site_url();?>admin/clientservices">Client Services </a><a > | </a>
		    <a href="<?php echo site_url();?>admin/addclient">Add Client</a>
	       </span>
	  </div>
	  <div class="tab-menu">		
	       <div class="tab-content"></br>
		    <?php echo $this->session->flashdata('message'); ?>
		    <br/>
		    <div class="main-tab">
			 <div class="tab-content-left-table">
			      <div class="stdListing">
				   <?php  
					$attributes = array('id' => 'listingForm', 'name' => 'listingForm');
					echo form_open("admin/setpermission/$userid", $attributes);
					
					if(@$userpermissions['permissionId']){
					     $permissionarray=json_decode($userpermissions['permissionId']);
					}
					?>
				   <table width="100%" cellspacing="0" cellpadding="0" border="0">
					<colgroup>
					     <col width="25">
					     <col width="250">
					</colgroup>
					<tbody>
					     <tr>
						     <th scope="col">Permissions</th>
						     <th scope="col">Status</th>
					     </tr>
					     <?php if(count($results )>0) { $i=0;?>
						       <?php foreach($results as $permissionlist) {
							  if ($i % 2 == 1) {  $class = "alternateRow";}
							  else {	$class = "";	}
						       ?>
						  <tr class="<?php echo $class;?>">
							<td scope="col"><?php echo ucwords($permissionlist['permissionName']); ?></td>
							<td scope="col"><?php //echo $permissionlist['id'] ?>
							    <div>
							    <?php
							    $id = $permissionlist['id'];
							    $chk =  '0';
							    $i = 1;
							    if(isset($select_usr_permission)){
							    foreach($select_usr_permission as $k=>$val){
								 if($i==$permissionlist['id']){
								 if($val=='yes'){ ?>
								    <div style="float:left"> 
								      <div class="radio-input">Yes</div>
								      	<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="yes" id="<?php echo $permissionlist['id'];?>" <?php echo "checked='checked'";?>/>
								      </div>
								      <div style="float:left">
								      <div class="radio-input">No</div>
									   <input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="no" id="<?php echo $permissionlist['id'];?>" <?php //if($ky==$permissionlist['id'] && $val=='no'){ echo "checked='unchecked'";}?>/>
								      </div>
								    <?php } else { ?>
								   <div style="float:left"> 
								      <div class="radio-input">Yes</div>
								      	<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="yes" id="<?php echo $permissionlist['id'];?>" />
								      </div>
								      <div style="float:left">
								      <div class="radio-input">No</div>
									   <input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="no" id="<?php echo $permissionlist['id'];?>" <?php echo "checked='checked'";?><?php //if($ky==$permissionlist['id'] && $val=='no'){ echo "checked='unchecked'";}?>/>
								      </div>
								   <?php   
								      }
								 }
								 $i++;
							    } } if(empty($select_usr_permission)){ ?>
								      <div style="float:left"> 
								      <div class="radio-input">Yes</div>
								      	<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="yes" id="<?php echo $permissionlist['id'];?>" />
								      </div>
								      <div style="float:left">
								      <div class="radio-input">No</div>
									   <input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="no" id="<?php echo $permissionlist['id'];?>" <?php echo "checked='checked'";?><?php //if($ky==$permissionlist['id'] && $val=='no'){ echo "checked='unchecked'";}?>/>
								      </div>
							   <?php } ?>
							     </div>
							</td>
						</tr>
					     <?php } ?>
						  <tr>
						       <td colspan="1">
							    <?php echo form_hidden('userId', $userid,'id="userId" maxlength="15"');?>
							    <?php echo form_hidden('permissionid', @$userpermissions['id'],'id="permissionid" maxlength="15"');?>
							    <div class="input-radio"><input value="Submit" class="sign" type="submit" name="setpermission" /></div>
						       </td>
						  </tr>

					     <?php } else {?>
					     <tr>
						     <td scope="col" colspan="7"><div class="alert-error">No result found to be display here.</div></td>
					     </tr>
					     <?php } ?>
					     
					</tbody>
				   </table>
				   <?php echo form_close(); ?>
			      </div>					
			 </div>
		    </div>
		
	       </div>
	  </div>
	  <script type="text/javascript">
	 $('.selActions').change(function() {
			var vale = $(this).val();
			var atrrid = $(this).attr('id');
			var valee = '/numera/admin/'+vale+'/'+atrrid;
			var formurl = valee;
			$("#listingForm").attr("action",formurl);
			$("#listingForm").attr("method",'POST');
			$("#listingForm").submit();
			return true
		});
	
	  </script>
<?php $this->load->view('admin_footer')?>