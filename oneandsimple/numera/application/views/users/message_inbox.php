<?php $this->load->view('header') ?>
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

<div class="section-right">
    <div class="msg-menu">
        <a href="<?php echo base_url(); ?>users/messagebox" <?php if(@$submenu=='9a'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('messagebox'); ?>  </a>
        <!--a href="<?php echo base_url(); ?>users/messageOutbox" <?php if(@$submenu=='9b'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('outbox'); ?>  </a-->
        <a href="<?php echo base_url(); ?>users/composeMessage" <?php if(@$submenu=='9c'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('compose'); ?> </a>
    </div>
    <div class="headind">
        <h2><?php echo $this->lang->line('messagebox'); ?></h2>
    </div>
    <div class="clear"> <?php echo $this->session->flashdata('message'); ?></div>
    <div class="contentwrapper" id="contentwrapper">
        <br clear="all">

<?php if($inbox_message){ ?>
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
                                <th width="5%" class="head0"><?php echo $this->lang->line('sno'); ?></th>
                                <th width="5%" class="head1"><img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></th>
                                <th width="20%" class="head0"><?php echo $this->lang->line('subject'); ?></th>
                                <th width="35%" class="head1"><?php echo $this->lang->line('message'); ?></th>
                                
                                <th width="15%" class="head0"><?php echo $this->lang->line('recipient'); ?></th>
                                
                                <th width="12%" class="head1"><?php echo $this->lang->line('date'); ?></th>
                                <th width="8%" class="head1"><img src="<?php echo base_url() . 'images/icons/reply.png'; ?>" height="25px" width="25px" /></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //  pre($inbox_message);
                            $i = 1;
                            foreach ($inbox_message as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php if ($val['attachment'] != '') { ?>
                                        <?php  $fileArray= explode('.',$val['attachment']); 
                                               $fileExtension = $fileArray[1]; 
                                               if(isset($fileExtension) && $fileExtension!=''){
                                        ?>
                                                <a href="<?php echo base_url();?>users/download_file?file=<?php echo $val['attachment']; ?>">
                                                    <img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" />
                                                </a>
                                               <?php } else{ ?>
                                                <a href="<?php echo base_url();?>users/downloadFile_drive/<?php echo $val['attachment']; ?>">
                                                    <img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" />
                                                </a>
                                               <?php } ?>
                                        <?php } ?>
                                    </td>
					<?php 
					if($val['notification_flag']=='0'){
						   $boldtag= "style='font-weight:bolder'";
						}
						else{
						    $boldtag= "";
						}
				
					?>
                                    <td <?php echo $boldtag; ?>>
						<a class="view_message msglist" msgid="<?php echo $val['id']; ?>" href="javascript:;">
							<?php if($val['unread'] <=0){ echo $val['subject'];} else{ echo"<b>".$val['subject']."</b>"; } ?>
						</a>
				    </td>
                                    <td <?php echo $boldtag; ?>>
						<a class="view_message msglist" msgid="<?php echo $val['id']; ?>" href="javascript:;">
							<?php echo $val['message']; ?>
						</a>
				    </td>
                                    <td>
                                        <?php 
                                            if($val['receiver']==$this->session->userdata('userid')){
                                                    echo ucfirst($val['sendername'].'- Sender');
                                                    $replyto = $val['senderuserId'];
                                                     $replyName = ucfirst($val['sendername']);
                                               }else{
                                            //if($val['senderuserId']==$this->session->userdata('userid')){
                                                    //echo ucfirst($val['rcvruserName'].'- Recipient');
                                                    echo ucfirst($val['sendername'].'- Recipient');
                                                    $replyto = $val['receiver'];
                                                    $replyName = ucfirst($val['rcvruserName']);
                                            } 
                                                //echo ucfirst($val['sendername']).' / '.ucfirst($val['rcvruserName']);
                                        ?>
                                    </td>
                                    <td><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>
                                    <td>
                                        <?php if($replyto!=$this->session->userdata('userid')){ ?>
                                            <a title="Click to Reply and View messages" href="<?php echo base_url() . 'users/msg_history/'.$val['id'].'/'.$replyName.'/'.$replyto; ?>">
                                                <img src="<?php echo base_url() . 'images/icons/reply.png'; ?>"/>
                                            </a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>

                        </tbody>

                    </table>
                    <div id="pagination"><?php echo $links; ?></div>
                </div></div> 
<?php }else{ ?>
            <div class="alert-error" style="margin-left:5px;margin-right: 5px;"><?php echo $this->lang->line('no_msg_inbox'); ?></div>
<?php } ?>

        <br clear="all">
    </div><!-- contentwrapper -->

    <div>
        <?php
        $this->load->view('footer')?>
