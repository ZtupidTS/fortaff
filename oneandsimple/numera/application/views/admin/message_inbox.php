<?php $this->load->view('admin_header') ?> 
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo base_url(); ?>javascript/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css?v=2.1.4" media="screen" /> 
<script type="text/javascript">
    $(document).ready(function() {


        $('.fancybox').fancybox();
        // Disable opening and closing animations, change title type
        $(".fancybox-effects-b").fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            helpers: {
                title: {
                    type: 'over'
                }
            }
        });

        $(".view_message").click(function() {
            var msgID = $(this).attr('msgid');

            $.fancybox.open({
                href: '<?php echo base_url(); ?>admin/view_message/?msgid=' + msgID,
                type: 'iframe',
                padding: 20
            });
        });

    });

</script>


<div class="centercontent">
    <div class="headind">
        <h2>Inbox</h2>
    </div>
    <div class="contentwrapper" id="contentwrapper">
        <br clear="all">
	<?php echo $this->session->flashdata('message'); ?>
        <br/>
        <?php if ($inbox_message) { ?>
            <div class="widgetbox">
                <div class="widgetcontent userlistwidget nopadding">

                    <table cellspacing="0" cellpadding="0" border="0" id="results" class="stdtable stdtablecb overviewtable2">
                        <colgroup>
                            <col class="con0">
                            <col class="con1">
                            <col class="con0">
                            <col class="con1">
                            <col class="con0">

                        </colgroup>
                        <thead>
                            <tr>
                                <th width="5%" class="head0">S.No</th>
                                <th width="5%" class="head1"><img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></th>
                                <th width="20%" class="head0">Subject</th>
                                <th width="40%" class="head1">Message</th>
                                <th width="12%" class="head0">To/From</th>
                                <th width="13%" class="head1">Date</th>
                                <th width="5%" class="head1"><img src="<?php echo base_url() . 'images/icons/reply.png'; ?>" /></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($inbox_message as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php if ($val['attachment'] != '') { ?>
                                            <a href="download_file/<?php echo $val['attachment']; ?>">
                                                <img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></a>

                                        <?php } ?>
                                    </td>
					<?php
						echo  $val['notification_flag'];
					  	if($val['notification_flag']=='0'){
						   $boldtag= "style='font-weight:bolder'";
						}
						else{
						    $boldtag= "";
						}	
					?>
                                    <td <?php echo $boldtag;?>> 
					
                                        <a class="view_message" msgid="<?php echo $val['id']; ?>" href="javascript:;">  <?php
							
		                                    if (strlen($val['subject']) <= 30)
		                                        echo $val['subject'];
		                                    else
		                                        echo substr($val['subject'], 0, 30) . '.....';
						
                                            ?>  
					</a></td>
                                    <td <?php echo $boldtag;?>><a class="view_message" msgid="<?php echo $val['id']; ?>" href="javascript:;">
                                            <?php
                                            if (strlen($val['message']) <= 100)
                                                echo $val['message'];
                                            else
                                                echo substr($val['message'], 0, 100) . '.....';
                                            ?>
                                        </a></td>
                                    <td><?php echo $val['userName']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>
                                    <td><a href="<?php echo base_url() . 'admin/msg_history/'.$val['id']; ?>">
                                            <img src="<?php echo base_url() . 'images/icons/reply.png'; ?>"/></a>
                                    </td>

                                </tr>
                                <?php
                                $count++;
                            }
                            ?>

                        </tbody>

                    </table>

                    <section id="pagination_my" class="animated for_animate">

                        <ul class="pagination m-b-none animated for_animate">
                            <?php echo $this->pagination->create_links(); ?>

                        </ul>
                    </section>
                </div>


            </div><!--contentwrapper-->
        <?php }else { ?>
            <div class="no-result">No messages in Inbox.</div>
        <?php } ?>
        <br clear="all">
    </div><!-- contentwrapper -->
</div>

<?php
$this->load->view('admin_footer')?>
