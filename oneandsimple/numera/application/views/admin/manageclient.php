<?php $this->load->view('admin_header')?>

<script type="text/javascript" >
	$(document).ready(function(){	
		$('.accountType').click(function(){
		       //$("#contactperson ul").clone().appendTo("#more");
		       var accountType = $(this).val();
		       if(accountType=='numera')
		       {
				$('.selfcss').css("display","none");
				$('#googlepassword').removeClass('required');
				$('#googlepassword').attr("value",'<?php echo NUMERA_GMAIL_PWD ?>');
				
				$('#googleemail').removeClass('required');
				$('#googleemail').attr("value",'<?php echo NUMERA_GMAIL_EMAIL ?>');
				
				//$('#googleemail').val();
				
				
		       }else{
				var oldemail = $('#gtempid').val();
				var oemail;
				if(oldemail!=null)
				{
					if(oldemail=='numera76@gmail.com')
					{
						oemail = "";		
					}else{
						oemail = oldemail;		
					}
					
				}else {
					oemail = null;	
				}
				
				$('.selfcss').css("display","block");
				$('#googlepassword').addClass('required');
				$('#googlepassword').attr("value",'');
				
				$('#googleemail').addClass('required');
				$('#googleemail').attr("value",oemail);
		       }
		       
		       
	       });
		
		$('#btnsubmit').click(function(){
				var username = $("#companyName").val();
				username = $.trim(username);
				$("#userName").attr("value",username);
			});
	});
</script>
	<div class="headind">
	     <h2><?php echo $title; ?> </h2>
		<?php if($this->uri->segment(3) && $clientId){?>
			<span class="admin-right-menu">
				<!--<a href="<?php echo site_url();?>admin/setpermission/<?php echo $this->uri->segment(3);?>">Set permissions </a><a>|</a>-->
				<a href="<?php echo site_url();?>admin/addUser/<?php echo $this->uri->segment(3);?>">Add User </a>
				<!--<a>|</a><a href="<?php echo site_url();?>admin/manageclientservice/<?php echo $this->uri->segment(3);?>">Add Service </a><a>|</a>
				<a href="<?php echo site_url();?>admin/managecontactperson/<?php echo $this->uri->segment(3);?>">Add contact person</a>-->
			</span>
			<?php $readonly="readonly='readonly'"; ?>
		<?php } else { $readonly = "";} ?>	
	</div>
	<iframe id="logoutframe" src="https://accounts.google.com/logout" style="display: none"></iframe>
	<div class="tab-menu">
		
		<div class="tab-content"></br>
			<?php echo $this->session->flashdata('message'); ?>
			<br/>
		<?php //pre($clientDetail); ?>
		<?php $attributes = array('name' => 'manageclients', 'id' => 'manageclients');?>
		<?php echo form_open_multipart("admin/manageclient/$clientId",$attributes);?>	
			<div class="main-tab">	
				<div class="tab-content-left">
					<!--Tab 1 For Add basic client information-->
					<ul class="tab-field">
						<li><i><strong>Google account login details</strong></i></li>
						<li>
							<span><?php echo form_label('Account type:', 'accountType','class="required"');?><em>*</em></span>
							<div class="input-divs">
							 <div style="margin-top:8px;">
								<?php if(isset($clientId) && $clientId!=null){ ?>
								<?php echo $clientDetail['moredetails']['accountType'];?>
									<input type="hidden" name="accountType" value="<?php echo @$clientDetail['moredetails']['accountType']; ?>" />
								<?php }else{ ?>
									<label style="font-size: 14px">Numera</label><input type="radio" name="accountType" id="accountType" class="accountType" value="numera" <?php if(@$clientDetail['moredetails']['accountType']=='numera' && @$clientId!='' ){ echo 'checked="checked"';} ?> style="margin-left: 7px;width: 50px;">
									<label style="font-size: 14px">&nbsp;&nbsp;&nbsp;Self</label><input type="radio"  id="accountType"  name="accountType" class="accountType" <?php if(@$clientDetail['moredetails']['accountType']=='self' && @$clientId!='' || @$_GET['msg']=='invalid' ){ echo 'checked="checked"'; } ?> value="self"  style="margin-left: 7px;width: 50px;">
								<?php } ?>
							 </div>
							</div>
							<?php echo form_error('accountType'); ?>
						</li>
						<?php if(@$clientDetail['moredetails']['accountType']=='self')
							{
								$oldclientemail =  @$clientDetail['googleemail'] ;
								if(isset($clientId) && $clientId!=null){
									$showhidden = "display:block";
									$hiddenpwd = "display:none";
									
								}else {
									$showhidden = "display:none";
								}
							
							}
							else {
								$oldclientemail = NUMERA_GMAIL_EMAIL;
								if(isset($clientId) && $clientId!=null){
									$showhidden = "display:block";
									$hiddenpwd = "display:block";
								}else {
									$showhidden = "display:none";
								}
							}

							if(isset($clientId) && $clientId!=null){
								if(@$clientDetail['googleemail'] !='')
								{ $clientpwd =@$clientDetail['googlepassword']; }
								else { $clientpwd = NUMERA_GMAIL_PWD; }
							}else{
								if(@$clientDetail['googleemail'] !='')
								{ $clientpwd =""; }
								else { $clientpwd = NUMERA_GMAIL_PWD; }
							}
						?>
						
						<?php if(@$_GET['msg']=='invalid'){ ?>
						<li class="selfcss" style="<?php echo $showhidden ?>">
							<span><?php echo form_label('Google email:', 'googleemail','class="required"');?><em>*</em></span>
							<div class="input-divs">
								<input type="text" name="googleemail" id="googleemail" value="<?php echo $oldclientemail; ?>" <?php echo $readonly; ?> >
								<?php //echo form_input('googleemail', @$clientDetail['googleemail'],"id='googleemail' $readonly");?>
							</div>
							<?php echo form_error('googleemail'); ?>
						</li>
						
						<li class="selfcss" style="<?php echo $showhidden ?>">
								<?php if(isset($clientId) && $clientId!=null){ ?>
									<!--<span><?php echo form_label('Password:', 'googlepassword','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_password('googlepassword', @$clientDetail['googlepassword'],'id="googlepassword" maxlength="55" placeholder="Leave Blank, if not change password"');?>
									</div>-->
								<?php }else{ ?>
									<span><?php echo form_label('Password:', 'googlepassword','class="required"');?><em>*</em></span>
									<div class="input-divs">
									<?php echo form_password('googlepassword', @$clientDetail['googlepassword'],'id="googlepassword" maxlength="55"');?>
									</div>
								<?php } ?>
							
							<?php echo form_error('googlepassword'); ?>
						</li>
						<?php } else {?>
						<li class="selfcss" style="<?php echo @$showhidden ?>">
							<span><?php echo form_label('Google email:', 'googleemail','class="required"');?><em>*</em></span>
							<div class="input-divs">
								<?php if(isset($clientId) && $clientId!=null){ ?>
									<div style="margin-top: 8px;"><?php echo $oldclientemail;?></div>
									<input type="hidden" name="googleemail" id="googleemail" value="<?php echo $oldclientemail;?>" <?php echo $readonly; ?> >
								<?php } else { ?>
									<input type="text" name="googleemail" id="googleemail" value=""  >
								<?php } ?>
								<?php //echo form_input('googleemail', @$clientDetail['googleemail'],"id='googleemail' $readonly");?>
								<input type="hidden" name="gtempid" id="gtempid" value="<?php echo $oldclientemail;?>">
							</div>
							<?php echo form_error('googleemail'); ?>
						</li>
						
						<li class="selfcss" style="<?php echo @$showhidden ?>">
								<?php if(isset($clientId) && $clientId!=null){ ?>
									<span><?php echo form_label('Password:', 'googlepassword','class=""');?></span>
									<div class="input-divs">
											<?php echo form_password('newgooglepassword', '','id="newgooglepwd" maxlength="55" placeholder="Leave Blank, if not change password"');?>
									</div>
									<?php echo form_error('newgooglepassword'); ?>
								<?php }else{ ?>
									<span><?php echo form_label('Password:', 'googlepassword','class="required"');?><em>*</em></span>
									<div class="input-divs">
										<?php echo form_password('googlepassword', $clientpwd,'id="googlepassword" maxlength="55"');?>
									</div>
									<?php echo form_error('googlepassword'); ?>
								<?php } ?>
							
							
						</li>
						<?php } ?>
						
						<li><i><strong>Personal details</strong></i></li>
						<li style="display: none">
							<span><?php echo form_label('Client Name:', 'userName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userName', @$clientDetail['userName'],'id="userName"');?>
							</div>
							<?php echo form_error('userName'); ?>
						</li>
						<li><span><?php echo form_label('Company Name:', 'companyName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('companyName', @$clientDetail['companyName'],'id="companyName" maxlength="150"');?>
							</div>
							<?php echo form_error('companyName'); ?>
						</li>
						<li>
							<span><?php echo form_label('Email:','userEmail','class="required"')?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userEmail',@$clientDetail['userEmail'],'id="userEmail"');?>
							</div>
							<?php echo form_error('userEmail');?>
						</li>
						<li><span><?php echo form_label('Address:', 'clientAddress','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_textarea('clientAddress', @$clientDetail['clientAddress'],'id="clientAddress"');?>
							</div>
							<?php echo form_error('clientAddress'); ?>
						</li>
						<li><span><?php echo form_label('Phone:', 'userPhone','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userPhone', @$clientDetail['userPhone'],'id="userPhone"');?>
							</div>
							<?php echo form_error('userPhone'); ?>
						</li>
						
						<li><span><?php echo form_label('Account manager:', 'accountManager','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('accountManager', @$clientDetail['accountManager'],'id="accountManager" maxlength="15"');?>
							</div>
							<?php echo form_error('accountManager'); ?>
						</li>
						
						<li><span><?php echo form_label('Image:','userImage','class="required"')?></span>
							<?php echo form_upload('userImage','id="image" class="fileupload"')?>
							<?php echo form_error('userImage');?>
							<?php if(isset($clientDetail['userImage'])){ ?>
							<img src="<?php echo base_url()?>/uploads/users/<?php echo @$clientDetail['userImage'];?>" style="width:80px;float: right;margin-top: 5px;margin-right: 13px;"/>
							<?php } ?>
							<?php echo form_hidden('userImage_old', @$clientDetail['userImage'],'id="userimage"');?>
						</li>
					</ul>
						
					<!--Tabe2 add client contact persone information-->
					<ul class="tab-field" id="contactperson">
						<li><i><strong>&nbsp;</strong></i></li>
				<!--If $contact_person_detail array is not empty-->
						<?php if(isset($contact_person_detail) &&  count($contact_person_detail)>0) {?>
							<?php  foreach($contact_person_detail as $key => $contact_person_detail){ ?>	
								<li><i><strong>Contact person</strong></i></li>
								<li>
									<span><?php echo form_label('Person Name:', 'personname','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personname]", @$contact_person_detail['name'],'id="<?php echo cp[$key][personname]?>"');?>
									</div>
									<?php echo form_error('personname'); ?>
								</li>
								<li>
									<span><?php echo form_label('Profession:', 'personprofession','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personprofession]", @$contact_person_detail['profession'],'id="<?php echo cp[$key][personprofession]?>"');?>
									</div>
									<?php echo form_error('personprofession'); ?>
								</li>
								<li>
									<span><?php echo form_label('Email:','personemail','class="required"')?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personemail]",@$contact_person_detail['email'],'id="<?php echo cp[$key][personemail]?>"');?>
									</div>
									<?php echo form_error('personemail');?>
								</li>
								<li><span><?php echo form_label('Phone:', 'personphone','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personphone]", @$contact_person_detail['phone'],'id="<?php echo cp[$key][personphone]?>"');?>
									</div>
									<?php echo form_error('personphone'); ?>							
								</li>
								<input type="hidden" id="contacpersonid" name="<?php echo "cp[$key][id]"?>" value="<?php echo @$contact_person_detail['id']; ?>"/>
								<input type="hidden" id="countcp" value="<?php echo count($contact_person_detail); ?>"/>
							<?php } ?>
						<?php } else{ ?>
				<!--If $contact_person_detail array is empty-->
							<li><i><strong>Contact person</strong></i></li>
							<li>
								<span><?php echo form_label('Person Name:', 'personname','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personname', @$contact_person_detail['name'],'id="personname"');?>
								</div>
								<?php echo form_error('personname'); ?>
							</li>
							<li>
								<span><?php echo form_label('Profession:', 'personprofession','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personprofession', @$contact_person_detail['profession'],'id="personprofession"');?>
								</div>
								<?php echo form_error('personprofession'); ?>
							</li>
							<li>
								<span><?php echo form_label('Email:','personemail','class="required"')?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personemail',@$contact_person_detail['email'],'id="personemail"');?>
								</div>
								<?php echo form_error('personemail');?>
							</li>
							<li><span><?php echo form_label('Phone:', 'personphone','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personphone', @$contact_person_detail['phone'],'id="personphone" maxlength="200"');?>
								</div>
								<?php echo form_error('personphone'); ?>							
							</li>
							<input type="hidden" id="countcp" value="0"/>
						<?php  } ?>
						<li>
							<img src="<?php echo base_url()?>images/icons/icn.add.new.gif" title="Add more Contact person" id="addMore"/>
							Add More contact person
							
						</li>
					</ul>
					
					<div id="addcperson" class="addcperson"></div><!--Add more contact person by javascript-->
				</div>
				<div class="tab-content-left2">
					<!--Tab 3 Set client permissions-->
				<!--
					<ul class="tab-field">
						<li><i><strong>Set Permission</strong></i></li>
						<li>
							<div class="stdListing">
								<?php  
								//if(@$userpermissions['permissionId']){
								  //   $permissionarray=json_decode($userpermissions['permissionId']);
								//}
								?>
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<colgroup>
									     <col width="25">
									     <col width="250">
									</colgroup>
									<tbody>
				-->					
								<!--comment global permision		<tr>
											<th scope="col">Permissions</th>
											<th scope="col">Status</th>
										</tr>
										<?php if(count($results )>0)
										{ 	$i=0;?>
										       <?php foreach($results as $permissionlist)
										       {
											  if ($i % 2 == 1) {  $class = "alternateRow";}
											  else {	$class = "";	}
										       ?>
											<tr class="<?php echo $class;?>">
												<td scope="col"><?php echo ucwords($permissionlist['permissionName']); ?></td>
												<td scope="col"><?php //echo $permissionlist['id'] ?>
													<div>
														<?php $id = $permissionlist['id']; $chk =  '0'; $i = 1;
														if(isset($select_usr_permission))
														{
															foreach($select_usr_permission as $k=>$val)
															{
																if($i==$permissionlist['id'])
																{
																	if($val=='yes')
																	{
															?>
																		<div style="float:left"> 
																			<div class="radio-input">Yes</div>
																			<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="yes" id="<?php echo $permissionlist['id'];?>" <?php echo "checked='checked'";?>/>
																		</div>
																		<div style="float:left">
																			<div class="radio-input">No</div>
																			<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="no" id="<?php echo $permissionlist['id'];?>" <?php //if($ky==$permissionlist['id'] && $val=='no'){ echo "checked='unchecked'";}?>/>
																		</div>
																	<?php
																	}else
																	{ ?>
																		<div style="float:left"> 
																		   <div class="radio-input">Yes</div>
																		     <input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="yes" id="<?php echo $permissionlist['id'];?>" />
																		   </div>
																		   <div style="float:left">
																		   <div class="radio-input">No</div>
																			<input class="radio-input" name="pid[<?php echo $permissionlist['id'];?>]" type="radio" value="no" id="<?php echo $permissionlist['id'];?>" <?php echo "checked='checked'";?><?php //if($ky==$permissionlist['id'] && $val=='no'){ echo "checked='unchecked'";}?>/>
																		</div>
														<?php   		}
																}
														 $i++;
															}
														} if(empty($select_usr_permission)){ ?>
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
										<?php   } ?>
									<?php   }
									else{	?>
										<tr>
										     <td scope="col" colspan="7"><div class="alert-error">No result found to be display here.</div></td>
										</tr>
									<?php } ?>
										<tr>  <td scope="col" colspan="7"> &nbsp;</td></tr>
										<tr>
											<td scope="col" colspan="7"> <strong>Folders</strong></td>
										</tr>
										
									       <tr>
										       <th scope="col"></th>
										       <th scope="col"></th>
									       </tr>
								-->		
										<!--Folder Listing-->
										<?php //pre($folders); ?>
								<!--comment folder permsion		<?php if(count($folders )>0) { $i=0;?>
											     <?php foreach($folders as $folderslist) {
												if ($i % 2 == 1) {  $class = "alternateRow";}
												else {	$class = "";	}
											     ?>
											<tr class="<?php echo $class;?>">
											      <td scope="col"><?php echo ucwords($folderslist['folderName']); ?></td>
											      <td scope="col"><?php //echo $permissionlist['id'] ?>
												  <div>
												  <?php
												  $id = $folderslist['id'];
												  $chk =  '0';
												  $i = 1;
												  if(isset($select_client_folder_permission)){
												  foreach($select_client_folder_permission as $k=>$val){
												       if($k==$folderslist['id']){
													?>
														<div class="clear"></div>
														<div style="float:left">
														<?php if(@$val->Createfolder=='accept'){?>
															<div class="radio-input">Add folder <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfolder]" value="accept" checked="checked"></div>
														<?php }else{?>
															<div class="radio-input">Add folder <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfolder]" value="accept" ></div>	
														<?php }														
														if(@$val->Createfile=='accept'){?>
															<div class="radio-input">Add file <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfile]" value="accept" checked="checked"></div>
														<?php }else{ ?>
															<div class="radio-input">Add file <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfile]" value="accept"></div>
														<?php } if(@$val->Rename=='accept'){?>
															<div class="radio-input">Rename <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Rename]" value="accept" checked="checked"></div>
														<?php }else{?>
															<div class="radio-input">Rename <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Rename]" value="accept"></div>
														<?php }if(@$val->Delete=='accept'){?>	
															<div class="radio-input">Delete <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Delete]" value="accept" checked="checked"></div>
														<?php }else{?>
															<div class="radio-input">Delete <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Delete]" value="accept" ></div>
														<?php }?>
														</div>
													<?php 	 
												       }
												       $i++;
												  } } if(empty($select_client_folder_permission)){ ?>
													    <div class="clear"></div>
													    <div style="float:left">
														<div class="radio-input">Add folder <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfolder]" value="accept" checked="checked" ></div>
														<div class="radio-input">Add file <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Createfile]" value="accept" checked="checked"></div>
														<div class="radio-input">Rename <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Rename]" value="accept" checked="checked"></div>
														<div class="radio-input">Delete <input type="checkbox" name="folderpermission[<?php echo $folderslist['id']?>][Delete]" value="accept" checked="checked"></div>
													    </div>	
												 <?php } ?>
												   </div>
											      </td>
											</tr>
										   <?php } ?>
										   <?php } else {?>
											<tr>
												<td scope="col" colspan="7"><div class="alert-error">No result found to be display here.</div></td>
											</tr>
										   <?php } ?>
								-->		   
				<!--					</tbody>
								</table>
							</div>
						</li>
					</ul>			
				-->			
					<!--Tabe 4 Add Client Service-->		
					<ul class="tab-field">
						<?php if(isset($clientDetail['id'])){ } ?>
				<!--If $client_service_list_detail array is not empty-->
					<?php if(isset($client_service_list_detail) &&  count($client_service_list_detail)>0) {?>
							<?php  foreach($client_service_list_detail as $ky => $client_service_detail){ ?>
						<li> <i><strong> Client Service</strong></i></li>
						<li>
							<span><?php echo form_label('Service Name:', 'serviceName','class="required"');?></span>
							<div class="input-divs">
							<?php echo form_input("services[$ky][serviceName]", @$client_service_detail['serviceName'],'id="services[$ky][serviceName]"');?>
							</div>
							<?php echo form_error('serviceName'); ?>
						</li>
						<li>
							<span><?php echo form_label('Description:', 'serviceDescription','class="required"');?></span>
							<div class="input-divs">
							<?php echo form_textarea("services[$ky][serviceDescription]", @$client_service_detail['serviceDescription'],'id="services[$ky][serviceDescription]" ');?>
							</div>
							<?php echo form_error('serviceDescription'); ?>
						</li>
						<li>
							<span><?php echo form_label('Starting Date:','startingDate','class="required"')?></span>
							<div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input("services[$ky][startingDate]",@$client_service_detail['startingDate'],'id="services[$ky][startingDate]" class="startingDate"');?>
							      </div>
							      <pre style="display: none">$('.startingDate').datetimepicker();</pre>
							</div>
							<?php echo form_error('startingDate');?>
						</li>
						<li><span><?php echo form_label('Ending Date:', 'phone','class="required"');?></span>
							 <div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input("services[$ky][endingDate]", @$client_service_detail['endingDate'],'id="services[$ky][endingDate]"class="endingDate"');?>
							      </div>
							      <!--<pre style="display: none">$('.endingDate').datetimepicker();</pre>-->
							      
							 </div>
							<?php echo form_error('endingDate'); ?>
						</li>
								<input type="hidden" id="clientserviceid" name="<?php echo "services[$ky][id]"?>" value="<?php echo @$client_service_detail['id']; ?>"/>
								<input type="hidden" id="countservice" value="<?php echo count($client_service_list_detail); ?>"/>
							<?php } ?>
						<?php } else{ ?>		
				<!--If $contact_person_detail array is  empty-->
						<li> <i><strong> Client Service</strong></i></li>
						<li>
							<span><?php echo form_label('Service Name:', 'serviceName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('serviceName', @$client_service_detail['serviceName'],'id="serviceName"');?>
							</div>
							<?php echo form_error('serviceName'); ?>
						</li>
						<li>
							<span><?php echo form_label('Description:', 'serviceDescription','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_textarea('serviceDescription', @$client_service_detail['serviceDescription'],'id="serviceDescription"" ');?>
							</div>
							<?php echo form_error('serviceDescription'); ?>
						</li>
						<li>
							<span><?php echo form_label('Starting Date:','startingDate','class="required"')?><!--<em>*</em>--></span>
							<div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input('startingDate',@$client_service_detail['startingDate'],'id="startingDate1"');?>
							      </div>
							      <pre style="display: none">$('#startingDate1').datetimepicker();</pre>
							</div>
							<?php echo form_error('startingDate');?>
						</li>
						<li><span><?php echo form_label('Ending Date:', 'phone','class="required"');?><!--<em>*</em>--></span>
							 <div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input('endingDate', @$client_service_detail['endingDate'],'id="endingDate1"');?>
							      </div>
							      <pre style="display: none">$('#endingDate1').datetimepicker();</pre>
							      
							 </div>
							<?php echo form_error('endingDate'); ?>
						</li>
							<input type="hidden" id="countservice" value="0"/>
						<?php } ?>	
						<li>
							<img src="<?php echo base_url()?>images/icons/icn.add.new.gif" title="Add more services" id="addmoreservices"/>
							Add More Services
							
						</li>
					</ul>
					<div id="addclientservice" class="addclientservice"></div><!--Add more client services by javascript-->
				</div>
				
			</div>
			<div class="input-radio" style="float: left">
				<?php echo form_hidden('id', @$clientDetail['id'],'id="clientid" maxlength="15"');?>
				<input value="Submit" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
			</div>
			<?php echo form_close();?>
		</div>
	</div>
<?php $this->load->view('admin_footer')?>