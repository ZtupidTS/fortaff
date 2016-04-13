<?php $this->load->view('admin_header')?>

<!--Get client folders on change select box-->
<script type="text/javascript">
     	$(document).ready(function(){
		
		
		$('#newuserPassword').change(function() {
		  var option = $(this).val();
		  if(option!='')
		  {
			$("#changepwdrequest").val("yes");
			
		  }else{
		    return false;
		    } 
		});
		
		$('#clientid').change(function() {
		  var option = $(this).val();
		  var userid = $("#selectuerid").val();
		  if(option!='')
		  {
			 $.get('<?php echo base_url();?>admin/getclientfolders/'+option+'/'+userid, function(data) {
			   //alert(data);
			   $('#clientfolders').html(data).hide().fadeIn(1000);
			   if(data)
			   {
			      $('#infoclass').hide();
			   }else{
			      $('#infoclass').show();
			   }
			   
			 });
		  }else{
		    return false;
		    } 
		});
		
		<?php 
			//if(!empty($userDetail['clientId'])){
			//	echo "$('#clientid').trigger('change');";
			//}	
		?>
		
	       $('#userName').blur(function() {
		  var option = $(this).val();
		  var existuser = $('#existuserName').val();  
		  if(option!='')
		  {
			 $.get('<?php echo base_url();?>admin/checkUser_jquery/'+option, function(data) {
			     // alert(data);
			      if(data==1 && existuser!=option) {
				   $('#userName').addClass("error");
				   $('#usererror').html('<div for="userName" generated="true" class="error">User name allready exist, please try another.</div>');
				   $('#userName').removeClass("valid");
				   $('#btnsubmit').attr("disabled", "disabled");
				   return false
			      }else{
				   $('#userName').removeClass("error");
				   $('#btnsubmit').removeAttr("disabled");
				   return true;
			      }
			 });
		  }else{
		    return false;
		    } 
		});
	});
</script>

     <div class="headind">
	     <h2><?php echo $title; ?></h2>
		<?php if($this->uri->segment(3) && $userId){?>
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
	       <?php //pr($clientlist); ?>
	       <?php $attributes = array('name' => 'manageuser', 'id' => 'manageuser');?>
	       <?php echo form_open_multipart("admin/manageuser/$userId/",$attributes);?>
	       <div class="main-tab">
			 <div class="tab-content-left">
					<?php //pre($userDetail); ?>
				   <ul class="tab-field">
					<li>
						 <span><?php echo form_label('Language:', 'userlanguage','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						       <select name="userlanguage" id="userlanguage" class="select required" >
							    <option value = "">- Select language -</option>
							    <option value = "english" <?php if('english'==@$userDetail['userlanguage']){ echo "selected";} ?>>English</option>
							    <option value = "portugal" <?php if('portugal'==@$userDetail['userlanguage']){ echo "selected";} ?>>Portugu&#234;s</option>
						       </select>
						 </div>
						 <?php echo form_error('userlanguage'); ?>
					</li>
					
					<li>
						 <span><?php echo form_label('Client Name :', 'clientid','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						       <select name="clientid" id="clientid" class="select required" >
							    <option value = "">- Select -</option>
							    <?php if(isset($clientlist)){
								 foreach($clientlist as $val)
								 {?>
								      <option value = "<?php echo $val['id']; ?>" <?php if($val['id']==@$userDetail['clientId']){ echo "selected";} ?>><?php echo $val['userName'];?></option>
								 
							    <?php } }?>
						       </select>
						 </div>
						 <?php echo form_error('clientid'); ?>
					</li>
					 <li>
						 <span><?php echo form_label('User Login Name:', 'userName','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('userName', @$userDetail['userName'],'id="userName"');?>
						 </div>
						 <?php echo form_error('userName'); ?>
						 <div id="usererror"></div>
					</li>
					 <?php  if(empty($userDetail['id'])) {?>
					<li>
						 <span><?php echo form_label('Password:', 'userPassword','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_password('userPassword', @$userDetail['userPassword'],'id="userPassword"');?>
						 </div>
						 <?php echo form_error('userPassword'); ?>
					</li>
					 <?php }else { ?>
						<li>
							<span><?php echo form_label('Password:', 'userPassword','class="required"');?><!--<em>*</em>--></span>
							<div class="input-divs">
							<?php echo form_password('newuserPassword', '','id="newuserPassword" placeholder="Leave blank,if not change password"');?>
							</div>
							<?php echo form_error('newuserPassword'); ?>
						</li>
					 <?php } ?>
					<li>
						 <span><?php echo form_label('Email:','userEmail','class="required"')?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('userEmail',@$userDetail['userEmail'],'id="userEmail"');?>
						 </div>
						 <?php echo form_error('userEmail');?>
					</li>
					<li>
						 <span><?php echo form_label('First Name:', 'fname','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('fname', @$userDetail['fname'],'id="fname"');?>
						 </div>
						 <?php echo form_error('fname'); ?>
					</li>
					<li>
						 <span><?php echo form_label('Last Name:', 'lname','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('lname', @$userDetail['lname'],'id="lname"');?>
						 </div>
						 <?php echo form_error('lname'); ?>
					</li>
				       
					<li>
						 <span><?php echo form_label('Profession:', 'profession','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('profession', @$userDetail['profession'],'id="profession"');?>
						 </div>
						 <?php echo form_error('profession'); ?>
					</li>
				       
					<li><span><?php echo form_label('Phone:', 'userPhone','class="required"');?><em>*</em></span>
						 <div class="input-divs">
						 <?php echo form_input('userPhone', @$userDetail['userPhone'],'id="userPhone"');?>
						 </div>
						 <?php echo form_error('userPhone'); ?>
					</li>
						<li><span><?php echo form_label('One and Simple :', 'oneNsimpleUsr','class="required"');?></span>
												     <div class="radio-input" style="margin-top:8px;">
												         <label style="font-size:14px;color:#010101">User</label>
												            <?php $isnumerausr = @$userDetail['oneNsimpleUsr']; ?>
												         <input type="checkbox" <?php if($isnumerausr=='y'){ echo 'checked="checked"';}?>  name="oneNsimpleUsr" value="accept" style="margin-top:2px;">
												     </div>
												    <?php //echo form_input('onensimpleUsr', @$userDetail['userPhone'],'id="userPhone"');?>
												 <?php echo form_error('onensimpleUsr'); ?>
					</li>
					<li>
					 <span><?php echo form_label('Image:','userImage','class="required"')?></span>
						 <div class="input-divs">
						 <?php echo form_upload('userImage','id="image"')?>
						 </div>
						 <?php echo form_error('userImage');?>
						 <?php if(isset($userDetail['userImage'])){ ?>
						 <img src="<?php echo base_url()?>/uploads/users/<?php echo @$userDetail['userImage'];?>" style="width:80px;float: right;margin-top: 5px;margin-right: 13px;"/>
						 <?php } ?>
						 <?php echo form_hidden('userImage_old', @$userDetail['userImage'],'id="userimage"');?>
					 </li>
				   </ul>
			 </div>
			 <div class="tab-content-left2">
			 <!--Tab 3 Set client permissions-->
			      <ul class="tab-field">
			      <li><i><strong>Set Permission</strong></i></li>
			      <li>
				   <div class="stdListing">
				   <?php  
				   /*if(@$userpermissions['permissionId']){
					$permissionarray=json_decode($userpermissions['permissionId']);
				   }*/
				   ?>
					<table width="100%" cellspacing="0" cellpadding="0" border="0" id="clientfolders">
					     <colgroup>
					     <col width="25">
					     <col width="250">
					     </colgroup>
					     <!--if user is exist-->
					     <?php if(isset($userId)){ ?>
					     <tbody>
						  <tr>  <td scope="col" colspan="7"> &nbsp;</td></tr>
						  <tr>	<td scope="col" colspan="7"> <strong>Folders</strong></td></tr>
						  <tr>	<th scope="col"></th><th scope="col"></th></tr>
					
						  <!--Folder Listing-->
						  <?php //pre($folders);
							//pre($select_client_folder_permission);	
						  ?>
						  <?php if(count($folders )>0) { $i=0;?>
						  <?php foreach($folders as $folderslist) {
						  if ($i % 2 == 1) {  $class = "alternateRow";}
						  else {	$class = "";	}
						  ?>
						
						  <tr class="<?php echo $class;?>" >
						       <td scope="col"><?php echo ucwords($folderslist['folderName']); ?></td>
						       <td scope="col"><?php //echo $permissionlist['id'] ?>
						       <div>
							    <?php
							    $id = $folderslist['id'];
							    $chk =  '0';
							    $i = 1;
							   // if(isset($select_client_folder_permission)){
							//	 foreach($select_client_folder_permission as $k=>$val){
							//	      if($k==$folderslist['id']){
								      ?>
								      <div class="clear"></div>
								      <div style="float:left">
								      <!--file permission-->
									   <table>
										<tr>
										     <td colspan="3"><strong>File</strong></td>
										     
										</tr>
										<tr>
										     <td>  
											  <div class="radio-input">
											      
											      <?php
													if(!empty($select_client_folder_permission[$folderslist['id']]->Createfile) && $select_client_folder_permission[$folderslist['id']]->Createfile == "accept"){
														$checked = 'checked="checked"';
													}
													else{
														$checked = '';
													}
											      ?>
											      
											       Add <input type="checkbox" <?php echo $checked;?> name="folderpermission[<?php echo $folderslist['id']?>][Createfile]" value="accept">
											  </div>
										     </td>
										     <td>
											  <div class="radio-input">
											       <!--<input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][movefile]" value="accept" checked="checked">-->
											          
											       <?php if(!empty($select_client_folder_permission[$folderslist['id']]->moovefile) && $select_client_folder_permission[$folderslist['id']]->moovefile == "accept"){
													$checked = 'checked="checked"';
												}else{
													$checked = '';
												}?>
												
												Move<input type="checkbox" <?php echo $checked;?> name="folderpermission[<?php echo $folderslist['id']?>][moovefile]" value="accept">
											  </div>
										     </td>
										     <td>
											  <div class="radio-input">
												 <?php if(!empty($select_client_folder_permission[$folderslist['id']]->Deletefile) && $select_client_folder_permission[$folderslist['id']]->Deletefile == "accept"){
													$checked = 'checked="checked"';
												}else{
													$checked = '';
												}?>
											        <!--<input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Deletefile]" value="accept" checked="checked">-->
												    Delete <input type="checkbox"  <?php echo $checked;?> name="folderpermission[<?php echo $folderslist['id']?>][Deletefile]" value="accept" >
											  </div>
										     </td>
										</tr>
										<!--Folder permission-->
										<tr>
										     <td colspan="3"><strong>Folder</strong></td>
										</tr>
										<tr>
										     <td>
											  <div class="radio-input">
											        <!--View-->
												 <?php if(!empty($select_client_folder_permission[$folderslist['id']]->Viewfolder) && $select_client_folder_permission[$folderslist['id']]->Viewfolder == "accept"){
													$checked = 'checked="checked"';
												}else{
													$checked = '';
												}?>
												  
												View <input type="checkbox" <?php echo $checked;?> name="folderpermission[<?php echo $folderslist['id']?>][Viewfolder]" value="accept" >
												  
												
											  </div>
										     </td>
										     <td>
											  <div class="radio-input">
											        <!--permission it true or not-->
												<div class="checkboxhidden" >
												    <?php if(@$val->permissiontrue=='accept'){?>
													 permission true<input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][permissiontrue]" value="accept" checked="checked">
												    <?php }else{?>
													 permission true<input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][permissiontrue]" value="accept" >
												    <?php }?>
												</div>    
											  </div>
  
										     </td>
										     <td>
											
										     </td>
										</tr>
										<tr>
										     <td></td>
										     <td></td>
										     <td></td>
										</tr>
									   </table>
								      </div>
								      
								      <?php 	 
								 //     }
								      $i++;
								 //     }
								      
								// }
								
								 ?>
								 
						       </div>
						  </td>
						  </tr>
						
						  <?php } ?>
						  <?php } else {?>
						  <tr>
						       <td scope="col" colspan="7"><div class="alert-error">No folder found to be display here.</div></td>
						  </tr>
						  <?php } ?>
					</tbody>
					     <?php } else { ?>
					     <!--else-->
						  <div class="alert-info" id="infoclass">Select any one client</div>
					     <?php } ?>
					</table>
				   </div>
			      </li>
			 </ul>			
		    </div>
	       </div>
	       <div class="input-radio" style="float:left">
		    <?php echo form_hidden('id', @$userDetail['userId'],'id="user_detail_id" maxlength="15"');?>
		    <?php echo form_hidden('userId', @$userDetail['userId'],'id="userid" maxlength="15"');?>
		    <input type="hidden"  name="username" value="<?php echo @$userDetail['userName'];?>" id="existuserName">
		    
		    <input type="hidden"  name="selectuerid" value="<?php echo @$userDetail['userId'];?>" id="selectuerid">
		    <input value="Submit" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
		   <input type="hidden"  name="changepwdrequest" value="" id="changepwdrequest">	
		    	
	       </div>
	       <?php echo form_close();?>		
		 
		</div>
	</div>
<?php $this->load->view('admin_footer')?>
