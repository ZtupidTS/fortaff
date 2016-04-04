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
    <h2><?php echo $this->lang->line('message'); ?></h2>
</div>

<div class="tab-menu">

    <div class="tab-content">
        <?php echo $this->session->flashdata('message'); ?>

        <div class="main-tab" style="width: 125%;">
            <div class="tab-content-left">
                <?php echo form_open_multipart('users/replyMessage', $attributes); ?>
                <ul class="tab-field">
                    <li>
                        <span><label for="messageTo"><?php echo $this->lang->line('to'); ?>:</label></span>
                        <div class="input-divs" ><?php echo $this->uri->segment('4'); ?></div>
                    </li>

                    <li>
                        <span><label for="message"><?php echo $this->lang->line('message'); ?>:</label><em>*</em></span>
                        <div class="input-divs" id='message'>
                           <textarea cols="30" rows="6" name="message" ></textarea></div>
                        <?php echo form_error('message'); ?>
                    </li>

                    <li>
                        <span><label for="attach"><?php echo $this->lang->line('attach_file'); ?>:</label><em></em></span>
                        <div class="input-divs">
                            <input type="file" name="attach" />
                        </div>
                        <?php echo form_error('attach'); ?>
                        <?php //echo 'By:'.$this->session->userdata('userId'); ?>
                        <?php //echo 'To :'.$msgto;?>
                        <input type="hidden" name="reply_id" value="<?php echo $reply_id;?>">
                        <input type="hidden" name="subject" value="<?php echo $subject;?>">
                        <input type="hidden" name="user_id" value="<?php echo $msgto;?>">          
                    </li>
                </ul>

                <div class="input-radio" style="float: left;padding-left: 150px;">
                    <input value="<?php echo $this->lang->line('reply'); ?>" class="sign" type="submit">
                </div>
                <?php echo form_close(); ?> 
            </div>
            <div style="clear:both">
             <?php
            foreach ($message as $key => $value) { ?>
                    <div class="msg_div" style="padding-left:60px;">
                       <div><label><b><?php echo $this->lang->line('by'); ?> : </b></label><?php if($value['message_type'] == 'inbox'){ echo $value['sendername']; }else{ echo "Admin"; }?></div>
                       <div><label><b><?php echo $this->lang->line('subject'); ?> : </b></label><?php echo $value['subject']; ?></div>
                       <div><label><b><?php echo $this->lang->line('message'); ?> : </b></label><?php echo $value['message']; ?></div>
                       <div><lable><b><?php echo $this->lang->line('created_date'); ?>: </b></lable><?php echo $value['created_date']; ?></div>
                    <div class="clear"></div>   
                    </div>
            <?php } ?>
                </div>
        </div>

    </div>
</div>
<?php $this->load->view('footer') ?>
