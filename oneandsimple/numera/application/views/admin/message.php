<link href="<?php echo base_url(); ?>css/admin_css/admin_style.css" rel="stylesheet" type="text/css" />
<div class="msg">
    <div class="msg_contant">
        <h2>Message</h2>
        <div class="msg_div">
            <label>Subject:</label>
           <span> <?php echo $message['subject']; ?></span>
            <div class="clear"></div>
        </div>
        <div class="msg_div">
            <label>Message:</label>
            <span><?php echo $message['message']; ?></span>

            <div class="clear"></div>
        </div>
         <div class="msg_div">
            <label>Date:</label>
            <span><?php echo $message['created_date']; ?></span>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>	

    </div>
</div>



