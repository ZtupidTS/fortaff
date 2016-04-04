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
        <h2>Outbox</h2>
    </div>
    <h2 align="center"> 
        <!--Message-->
        <?php echo $this->session->flashdata('item'); ?>
    </h2>

    <div class="contentwrapper" id="contentwrapper">
        <br clear="all">
        <?php if ($outbox_message) { ?>
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
                                <th width="5%" class="head0">S.no</th>
                                <th width="5%" class="head1"><img src="<?php echo base_url() . 'images/icons/attachment.png'; ?>" height="25px" width="25px" /></th>
                                <th width="20%" class="head0">Subject</th>
                                <th width="40%" class="head1">Message</th>
                                <th width="15%" class="head0">Recipient</th>
                                <th width="15%" class="head1">Date</th>
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
                                    <td> <a class="view_message" msgid="<?php echo $val['id']; ?>" href="javascript:;">  <?php
                                        if (strlen($val['subject']) <= 30)
                                            echo $val['subject'];
                                        else
                                            echo substr($val['subject'], 0, 30) . '.....';
                                        ?>  </a></td>
                                    <td><a class="view_message" msgid="<?php echo $val['id']; ?>" href="javascript:;">
                                            <?php
                                            if (strlen($val['message']) <= 100)
                                                echo $val['message'];
                                            else
                                                echo substr($val['message'], 0, 100) . '.....';
                                            ?>
                                        </a></td>
                                    <td><?php echo $val['userName']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>

                                </tr>
                                <?php
                                $i++;
                            }
                            ?>

                        </tbody>

                    </table>
                            <section id="pagination_my" class="animated for_animate">

                        <ul class="pagination m-b-none animated for_animate">
                            <?php echo $this->pagination->create_links(); ?>

                        </ul>
                    </section>
                </div></div> 
        <?php }else { ?>
            <div class="no-result">No messages in Outbox.</div>
        <?php } ?>

        <br clear="all">
    </div><!-- contentwrapper -->
</div>

<?php
$this->load->view('admin_footer')?>