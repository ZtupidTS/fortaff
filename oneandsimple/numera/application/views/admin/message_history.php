<?php $this->load->view('admin_header') ?> 
<!--link href="<?php echo base_url(); ?>css/admin_css/admin_style.css" rel="stylesheet" type="text/css" /-->
<div class="msg">
    <div class="msg_contant">
        <h2>Message</h2>
        <?php echo $this->session->flashdata('message'); ?>
<?php

foreach ($message as $key => $value) { ?>
        <div class="msg_div">
           <div><label>By : </label><?php if($value['message_type'] == 'inbox'){ echo $value['fname'].' '.$value['lname']; }else{ echo "Admin"; }?></div>
           <div><label>Subject : </label><?php echo $value['subject']; ?></div>
           <div><label>Message : </label><?php echo $value['message']; ?></div>
           <div><lable>Created Date: </lable><?php echo $value['created_date']; ?></div>
           <div class="clear"></div>
        </div>
<?php } ?>
        <div class="clear"></div>	
    <div class="tab-content-left">
                            <?php echo form_open_multipart('admin/replyMessage', $attributes); ?>                                              
        <ul class="tab-field">
                            <li>
                                <span><label for="message">Message:</label><em>*</em></span>
                                <div class="input-divs">
                                <textarea cols="30" rows="6" required name="message" ></textarea></div>
                                <?php echo form_error('message'); ?>
                            </li>
                            <li>
                                <span><label for="attach">Attachement:</label><em></em></span>
                                <div class="input-divs">
                                <input type="file" name="attach" />      
                                </div>
                                <?php echo form_error('attach'); ?>
                            </li>        
                            <input type="hidden" name="reply_id" value="<?php echo $reply_id;?>">
                            <input type="hidden" name="subject" value="<?php echo $subject;?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">          

        </ul>
        <div class="input-radio">
                            <input value="Reply" class="sign" type="submit">
                        </div>
    </form>
    </div>
    </div>
</div>



