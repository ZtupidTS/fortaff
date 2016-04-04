<?php $this->load->view('header') ?>
<div class="msg-menu">
    <a href="<?php echo base_url(); ?>users/messagebox" <?php
    if (@$submenu == '9a') {
        echo 'class="frontactive"';
    }
    ?>><?php echo $this->lang->line('messagebox'); ?>  </a>
    
    <a href="<?php echo base_url(); ?>users/composeMessage" <?php
    if (@$submenu == '9c') {
        echo 'class="frontactive"';
    }
    ?>><?php echo $this->lang->line('compose'); ?> </a>
</div>
<div class="headind">
    <h2><?php echo $this->lang->line('compose'); ?></h2>
</div>

<div class="tab-menu">

    <div class="tab-content">
        <?php echo $this->session->flashdata('message'); ?>

        <div class="main-tab">
            <div class="tab-content-left">
                <?php echo form_open_multipart('users/composeMessage', $attributes); ?>
                <ul class="tab-field">
                    <li>
                        <span><?php echo form_label($this->lang->line('select_user'), 'user', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs" id='user'>
			<?php 
                              $lusdDetail= get_user($this->session->userdata['userid']); /*Get Logged in user Detail*/
				//echo $lusdDetail->oneNsimpleUsr;
                              //pre();
                            ?>
                            <select class='select' name="user">
                                <option value="">Select User</option>
                                <option value="0">admin</option>
                                <?php
                                if(!empty($users) && $lusdDetail->oneNsimpleUsr=='y'){
                                 foreach ($users as $key => $val) { 
                                    if(isset($val['userName'])) $username = $val['userName']; 
                                    else $username = $val['fname'] . ' ' . $val['lname']; ?>
                                    <option value="<?php echo $val['id']; ?>"><?php echo $username; ?></option>
                                <?php } 
                                }?>       
                            </select>
                        </div>
                        <?php echo form_error('user'); ?>
                    </li>

                    <li>
                        <span><?php echo form_label($this->lang->line('subject') . ':', 'subject', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs">
                            <?php echo form_input('subject', '', 'id="subject"'); ?>
                        </div>
                        <?php echo form_error('subject'); ?>
                    </li>


                    <li><span><?php echo form_label($this->lang->line('message') . ':', 'message', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs">
                            <textarea name="message"></textarea>
                        </div>
                        <?php echo form_error('message'); ?>
                    </li>

                    <li><span><?php echo form_label($this->lang->line('attach_file') . ':', 'attach'); ?></span>
                        <div class="input-divs">
                            
                             <?php if(isset($file_detail['title'])){
                                echo $file_detail['title'];
                            }else{ ?>
                                <input type="file" name="attach" />
                            <?php } ?>
                            <input type="hidden" name="gmailFile" value="<?php echo $file_detail['fileId']; ?>"/>
                            <?php //pre($file_detail); ?>
                        </div>
                        <?php echo form_error('attach'); ?>
                    </li>
                </ul>

                <div class="input-radio">
                    <input value="<?php echo $this->lang->line('submit_value'); ?>" class="sign" type="submit">
                </div>
                <?php echo form_close(); ?>	
            </div>
        </div>

    </div>
</div>
<?php $this->load->view('footer') ?>
