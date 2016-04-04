    <?php if($this->session->userdata('loggedInAdmin')) {?>
                    </div><!--<div class="section">-->
                </div> <!--<div class="main-contnt">--> 
                <div class="clear"></div>
            </div>
            <div class="footer">
            	<p>                
                <?php $footertxt = get_adminFooter();
                    if(isset($footertxt->adminFooterTxt) && !empty($footertxt->adminFooterTxt)){
                ?>
                    <?php echo $footertxt->adminFooterTxt ?>
                <?php } else {?>
                    <?php echo date('Y');?> © one and simple 
                <?php } ?>
                </p>
            	<span>Powered by</span>
            	<div class="clear"></div>
            	<a href="http://www.oneandsimple.com/" target="_blank"><img src="<?php echo base_url();?>images/oneandsimple-logo.png" alt="" /></a> 
	    </div>            
            <div class="clear"></div>
        </div>
    <?php } ?>        
  </div>
        <script type="text/javascript">
		$(function(){
				$('.example-container > pre').each(function(i){
				eval($(this).text());
			});
		});
	</script>
</body>
</html>
