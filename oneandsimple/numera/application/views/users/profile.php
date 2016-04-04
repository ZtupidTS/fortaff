<?php $this->load->view('header')?>
    <div class="section-right">
        <div class="headind">
          <h2><?php echo $title; ?></h2>
        </div>
        <div class="clear"> <?php echo $this->session->flashdata('message'); ?></div>
        

        <?php //pre($user_folders_list);?>
        <div class="tab-content-left">
	    <br/>
            <?php //pr($userDetail); ?>
    <?php if($this->session->userdata('userRoleId')=='3'){ ?>
    <!--For user profile-->
                    <?php $attributes = array('name' => 'manageuser', 'id' => 'manageuser');?>
                    <?php echo form_open_multipart("users/manageuser/",$attributes);?>
                        <ul class="tab-field">
                                <li><i><strong><?php echo $this->lang->line('personal_details');?></strong></i></li>
                              <li>
                                      <span><?php echo form_label($this->lang->line('user_login_lbl'), 'userName','class="required"');?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('userName', @$userDetail['userName'],'id="userName"');?>
                                      </div>
                                      <?php echo form_error('userName'); ?>
                                      <div id="usererror"></div>
                             </li>
                             <li>
                                      <span><?php echo form_label($this->lang->line('email_lbl'),'userEmail','class="required"')?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('userEmail',@$userDetail['userEmail'],'id="userEmail"');?>
                                      </div>
                                      <?php echo form_error('userEmail');?>
                             </li>
                             <li>
                                      <span><?php echo form_label($this->lang->line('first_name_lbl'), 'fname','class="required"');?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('fname', @$userDetail['fname'],'id="fname"');?>
                                      </div>
                                      <?php echo form_error('fname'); ?>
                             </li>
                             <li>
                                      <span><?php echo form_label($this->lang->line('last_name_lbl'), 'lname','class="required"');?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('lname', @$userDetail['lname'],'id="lname"');?>
                                      </div>
                                      <?php echo form_error('lname'); ?>
                             </li>
                            
                             <li>
                                      <span><?php echo form_label($this->lang->line('profession_lbl'), 'profession','class="required"');?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('profession', @$userDetail['profession'],'id="profession"');?>
                                      </div>
                                      <?php echo form_error('profession'); ?>
                             </li>
                            
                             <li><span><?php echo form_label($this->lang->line('phone_lbl'), 'userPhone','class="required"');?><em>*</em></span>
                                      <div class="input-divs">
                                      <?php echo form_input('userPhone', @$userDetail['userPhone'],'id="userPhone"');?>
                                      </div>
                                      <?php echo form_error('userPhone'); ?>
                             </li>
                             <li>
                              <span><?php echo form_label($this->lang->line('image_lbl'),'userImage','class="required"')?></span>
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
                        <div class="input-radio" style="float:left">
                            <?php echo form_hidden('id', @$userDetail['id'],'id="user_detail_id" maxlength="15"');?>
                            <?php echo form_hidden('userId', @$userDetail['userId'],'id="userid" maxlength="15"');?>
                            <input value="Submit" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
                       </div>
                    <?php echo form_close();?>
    <?php   } else{ ?><!--Client profile.-->
                    <?php $attributes = array('name' => 'manageclients', 'id' => 'manageclients');?>
                    <?php echo form_open_multipart("users/manageclient/",$attributes);?>	
			<div class="main-tab">	
				<div class="tab-content-left">
					<!--Tab 1 For Add basic client information-->
					<ul class="tab-field">
						<li><i><strong><?php echo $this->lang->line('personal_details');?></strong></i></li>
						<li>
							<span><?php echo form_label($this->lang->line('name_lbl'), 'userName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userName', @$clientDetail['userName'],'id="userName"');?>
							</div>
							<?php echo form_error('userName'); ?>
						</li>
						<li><span><?php echo form_label($this->lang->line('company_name_lbl'), 'companyName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('companyName', @$clientDetail['companyName'],'id="companyName" maxlength="150"');?>
							</div>
							<?php echo form_error('companyName'); ?>
						</li>
						
						<li><span><?php echo form_label($this->lang->line('address_lbl'), 'clientAddress','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_textarea('clientAddress', @$clientDetail['clientAddress'],'id="clientAddress"');?>
							</div>
							<?php echo form_error('clientAddress'); ?>
						</li>
						
						<li>
							<span><?php echo form_label($this->lang->line('email_lbl'),'userEmail','class="required"')?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userEmail',@$clientDetail['userEmail'],'id="userEmail"');?>
							</div>
							<?php echo form_error('userEmail');?>
						</li>
						<li><span><?php echo form_label($this->lang->line('phone_lbl'), 'userPhone','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('userPhone', @$clientDetail['userPhone'],'id="userPhone"');?>
							</div>
							<?php echo form_error('userPhone'); ?>
						</li>
						
						<li><span><?php echo form_label($this->lang->line('account_mnger_lbl'), 'accountManager','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('accountManager', @$clientDetail['accountManager'],'id="accountManager" maxlength="15"');?>
							</div>
							<?php echo form_error('accountManager'); ?>
						</li>
						
						<li><span><?php echo form_label($this->lang->line('image_lbl'),'userImage','class="required"')?></span>
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
								<li><i><strong><?php echo $this->lang->line('contact_person_title') ?></strong></i></li>
								<li>
									<span><?php echo form_label($this->lang->line('person_name_lbl'), 'personname','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personname]", @$contact_person_detail['name'],'id="<?php echo cp[$key][personname]?>"');?>
									</div>
									<?php echo form_error('personname'); ?>
								</li>
								<li>
									<span><?php echo form_label($this->lang->line('profession_lbl'), 'personprofession','class="required"');?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personprofession]", @$contact_person_detail['profession'],'id="<?php echo cp[$key][personprofession]?>"');?>
									</div>
									<?php echo form_error('personprofession'); ?>
								</li>
								<li>
									<span><?php echo form_label($this->lang->line('email_lbl'),'personemail','class="required"')?></span>
									<div class="input-divs">
									<?php echo form_input("cp[$key][personemail]",@$contact_person_detail['email'],'id="<?php echo cp[$key][personemail]?>"');?>
									</div>
									<?php echo form_error('personemail');?>
								</li>
								<li><span><?php echo form_label($this->lang->line('phone_lbl'), 'personphone','class="required"');?></span>
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
								<span><?php echo form_label($this->lang->line('person_name_lbl'), 'personname','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personname', @$contact_person_detail['name'],'id="personname"');?>
								</div>
								<?php echo form_error('personname'); ?>
							</li>
							<li>
								<span><?php echo form_label($this->lang->line('profession_lbl'), 'personprofession','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personprofession', @$contact_person_detail['profession'],'id="personprofession"');?>
								</div>
								<?php echo form_error('personprofession'); ?>
							</li>
							<li>
								<span><?php echo form_label($this->lang->line('email_lbl'),'personemail','class="required"')?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personemail',@$contact_person_detail['email'],'id="personemail"');?>
								</div>
								<?php echo form_error('personemail');?>
							</li>
							<li><span><?php echo form_label($this->lang->line('phone_lbl'), 'personphone','class="required"');?><em>*</em></span>
								<div class="input-divs">
								<?php echo form_input('personphone', @$contact_person_detail['phone'],'id="personphone" maxlength="15"');?>
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
					<ul class="tab-field">
						<?php if(isset($clientDetail['id'])){ } ?>
				<!--If $client_service_list_detail array is not empty-->
					<?php if(isset($client_service_list_detail) &&  count($client_service_list_detail)>0) {?>
							<?php  foreach($client_service_list_detail as $ky => $client_service_detail){ ?>
						<li> <i><strong> Client Service</strong></i></li>
						<li>
							<span><?php echo form_label($this->lang->line('service_name_lbl'), 'serviceName','class="required"');?></span>
							<div class="input-divs">
							<?php echo form_input("services[$ky][serviceName]", @$client_service_detail['serviceName'],'id="services[$ky][serviceName]"');?>
							</div>
							<?php echo form_error('serviceName'); ?>
						</li>
						<li>
							<span><?php echo form_label($this->lang->line('description_lbl'), 'serviceDescription','class="required"');?></span>
							<div class="input-divs">
							<?php echo form_textarea("services[$ky][serviceDescription]", @$client_service_detail['serviceDescription'],'id="services[$ky][serviceDescription]" ');?>
							</div>
							<?php echo form_error('serviceDescription'); ?>
						</li>
						<li>
							<span><?php echo form_label($this->lang->line('start_date_lbl'),'startingDate','class="required"')?></span>
							<div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input("services[$ky][startingDate]",@$client_service_detail['startingDate'],'id="services[$ky][startingDate]" class="startingDate"');?>
							      </div>
							      <pre style="display: none">$('.startingDate').datetimepicker();</pre>
							</div>
							<?php echo form_error('startingDate');?>
						</li>
						<li><span><?php echo form_label($this->lang->line('end_date_lbl'), 'phone','class="required"');?></span>
							 <div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input("services[$ky][endingDate]", @$client_service_detail['endingDate'],'id="services[$ky][endingDate]"class="endingDate"');?>
							      </div>
							      <pre style="display: none">$('.endingDate').datetimepicker();</pre>
							      
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
							<span><?php echo form_label($this->lang->line('service_name_lbl'), 'serviceName','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_input('serviceName', @$client_service_detail['serviceName'],'id="serviceName"');?>
							</div>
							<?php echo form_error('serviceName'); ?>
						</li>
						<li>
							<span><?php echo form_label($this->lang->line('description_lbl'), 'serviceDescription','class="required"');?><em>*</em></span>
							<div class="input-divs">
							<?php echo form_textarea('serviceDescription', @$client_service_detail['serviceDescription'],'id="serviceDescription"" ');?>
							</div>
							<?php echo form_error('serviceDescription'); ?>
						</li>
						<li>
							<span><?php echo form_label($this->lang->line('start_date_lbl'),'startingDate','class="required"')?><em>*</em></span>
							<div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input('startingDate',@$client_service_detail['startingDate'],'id="startingDate"');?>
							      </div>
							      <pre style="display: none">$('#startingDate').datetimepicker();</pre>
							</div>
							<?php echo form_error('startingDate');?>
						</li>
						<li><span><?php echo form_label($this->lang->line('end_date_lbl'), 'phone','class="required"');?><em>*</em></span>
							 <div class="example-container">
							      <div class="input-divs">
							      <?php echo form_input('endingDate', @$client_service_detail['endingDate'],'id="endingDate"');?>
							      </div>
							      <pre style="display: none">$('#endingDate').datetimepicker();</pre>
							      
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
				<input value="<?php echo $this->lang->line('submit_value') ?>" class="sign" type="submit" name="btnsubmit">
			</div>
			<?php echo form_close();?> 
       <?php } ?>
  </div>
    </div>
<?php $this->load->view('footer')?>
