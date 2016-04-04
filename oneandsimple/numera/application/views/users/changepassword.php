<?php $this->load->view('header')?>
    <div class="section-right">
        <div class="headind">
          <h2><?php echo $this->lang->line('changepwd_lable');?></h2>
        </div>
        <div class="clear"> <?php echo $this->session->flashdata('message'); ?></div>
        <?php //pre($user_folders_list);?>
        <div class="tab-content-left">
	    <br/>
            <?php //pr($userDetail); ?>
	    <?php $attributes = array('name' => 'changepassword', 'id' => 'changepassword');?>
	    <?php echo form_open_multipart("users/changepassword/",$attributes);?>
		    <ul class="tab-field">
			<li>
				<span><?php echo form_label($this->lang->line('current_changepwd_lable'), 'userPassword','class="required"');?><em>*</em></span>
				<div class="input-divs">
				<?php echo form_password('userPassword','','id="userPassword"');?>
				</div>
				<?php echo form_error('userPassword'); ?>
				<div id="usererror"></div>
		       </li>
			<li>
				 <span><?php echo form_label($this->lang->line('new_changepwd_lable'),'newuserPassword','class="required"')?><em>*</em></span>
				 <div class="input-divs">
				 <?php echo form_password('updatepassword',@$userDetail['userPassword'],'id="newuserPassword"');?>
				 </div>
				 <?php echo form_error('updatepassword');?>
			</li>
			<li>
				 <span><?php echo form_label($this->lang->line('confirm_changepwd_lable'), 'confirmPassword','class="required"');?><em>*</em></span>
				 <div class="input-divs">
				 <?php echo form_password('confirmPassword','' ,'id="confirmPassword"');?>
				 </div>
				 <?php echo form_error('confirmPassword'); ?>
			</li>
		    </ul>
		    <div class="input-radio" style="float:left">
			<?php echo form_hidden('id', @$userDetail['id'],'id="user_detail_id" maxlength="15"');?>
			<input value="<?php echo $this->lang->line('front_search_sbmt_label') ?>" class="sign" type="submit" name="btnsubmit" id="btnsubmit">
		   </div>
	</div>
    </div>
<?php $this->load->view('footer')?>











