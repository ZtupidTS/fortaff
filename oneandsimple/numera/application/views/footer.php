  <?php if($this->session->userdata('loggedInUser')) {?>
                    </div><!--<div class="section">-->
                <div class="clear"></div>
            </div><!--<div class="main-contnt">--> 
            <div class="footer">
            	<p><?php $footertxt = get_adminFooter();
                    if(isset($footertxt->adminFooterTxt) && !empty($footertxt->adminFooterTxt)){
                ?>
                    <?php echo $footertxt->adminFooterTxt ?>
                <?php } else {?>
                    <?php echo date('Y');?> © one and simple 
                <?php } ?></p>
            	<span><?php echo $this->lang->line('power_by_label');?></span>
            	<div class="clear"></div>
            	<a href="http://www.oneandsimple.com/" target="_blank"><img src="<?php echo site_url()?>images/oneandsimple-logo.png" alt="" /></a> 
	    </div>
            <div class="clear"></div>
    <?php } ?>      
  </div> <!--Close wrapper div-->
</body>
</html>