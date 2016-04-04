<?php $this->load->view('admin_header') ?>
<div class="headind">
    <h2><?php echo $title; ?></h2>
</div>

<div class="tab-menu">

    <div class="tab-content"></br>
        <?php echo $this->session->flashdata('message'); ?>
        <br/>
        <div class="main-tab">
            <div class="tab-content-left">
                <?php echo form_open_multipart('admin/composeMessage', $attributes); ?>
                <ul class="tab-field">
                    <li>
                        <span><?php echo form_label('Select Client:', 'client'); ?></span>
                        <div class="input-divs">
                            <select class='select' id="client" name="client">
                                <option value="">Select Client</option>
                                <?php foreach ($clientlist as $key => $val) { ?>
                                    <option value="<?php echo $val['id']; ?>"><?php echo $val['userName']; ?></option>
                                <?php } ?>       
                            </select>
                        </div>
                        <?php echo form_error('user'); ?>
                    </li>

                    <li>
                        <span><?php echo form_label('Select User:', 'user', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs" id='user'>
                            <select class='select' name="user">
                                <option value="">Select User</option>
                                <?php foreach ($users as $key => $val) { ?>
                                    <option value="<?php echo $val['id']; ?>"><?php echo $val['fname'] . ' ' . $val['lname']; ?></option>
                                <?php } ?>       
                            </select>
                        </div>
                        <?php echo form_error('user'); ?>
                    </li>
                    <li>
                        <span><?php echo form_label('Subject:', 'subject', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs">
                            <?php echo form_input('subject', '', 'id="subject"'); ?>
                        </div>
                        <?php echo form_error('subject'); ?>
                    </li>


                    <li><span><?php echo form_label('Message:', 'message', 'class="required"'); ?><em>*</em></span>
                        <div class="input-divs">
                            <textarea name="message"></textarea>
                        </div>
                        <?php echo form_error('message'); ?>
                    </li>

                    <li><span><?php echo form_label('Attach file:', 'attach'); ?></span>
                        <div class="input-divs">
                            <input type="file" name="attach" />
                        </div>
                        <?php echo form_error('attach'); ?>
                    </li>
                </ul>

                <div class="input-radio">
                    <input value="Submit" class="sign" type="submit">
                </div>
                <?php echo form_close(); ?>	
            </div>
        </div>

    </div>
</div>
<?php $this->load->view('admin_footer') ?>
<script>
    $("#client").change(function() { 
        // call ajax function to get users of that client
        $.ajax({type: 'POST', url: '<?php echo base_url(); ?>admin/getAllUsers_byClientID', data: ({clientid: $(this).val()}), success: function(response) {
        
            $("#user").html(response);

        }
    });
            });
</script>
