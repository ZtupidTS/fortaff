<?php $this->load->view('header') ?>
<div class="section-right">
    <div class="msg-menu">
        <a href="<?php echo base_url(); ?>users/messageInbox" <?php if(@$submenu=='9a'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('inbox'); ?>  </a>
        <a href="<?php echo base_url(); ?>users/messageOutbox" <?php if(@$submenu=='9b'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('outbox'); ?>  </a>
        <a href="<?php echo base_url(); ?>users/composeMessage" <?php if(@$submenu=='9c'){ echo 'class="frontactive"';}?>><?php echo $this->lang->line('compose'); ?> </a>
    </div>
    <div class="headind">
        <h2><?php echo $this->lang->line('outbox'); ?></h2>
    </div>
    <div class="clear"> <?php echo $this->session->flashdata('message'); ?></div>
    <div class="contentwrapper" id="contentwrapper">
        <br clear="all">

           <?php if($outbox_message){ ?> 
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
                                <th width="8%" class="head0"><?php echo $this->lang->line('sno'); ?></th>
                                <th width="2%" class="head1"><img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></th>
                                <th width="20%" class="head0"><?php echo $this->lang->line('subject'); ?></th>
                                <th width="40%" class="head1"><?php echo $this->lang->line('message'); ?></th>
                                <th width="15%" class="head0"><?php echo $this->lang->line('recipient'); ?></th>
                                <th width="15%" class="head1"><?php echo $this->lang->line('date'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($outbox_message as $key => $val) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php if ($val['attachment'] != '') { ?>
                                            <a href="download_file/<?php echo $val['attachment']; ?>">
                                                <img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></a>

                                        <?php } ?>
                                    </td>
                                    <td><?php echo $val['subject']; ?></td>
                                    <td><?php echo $val['message']; ?></td>
                                    <td><?php echo 'admin'; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>

                                </tr>
                                <?php
                                $i++;
                            }
                            ?>

                        </tbody>

                    </table>
                    <div id="pageNavPosition"></div>
                </div></div> 
        <?php }else{ ?>
        <div class="no-result"><?php echo $this->lang->line('no_msg_outbox'); ?></div>
<?php } ?>

        <br clear="all">
    </div><!-- contentwrapper -->

    <div>
        <?php
        $this->load->view('footer')?>