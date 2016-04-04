<?php $this->load->view('header')?>
    <div class="section-right">
        <div class="headind">
          <h2><?php echo $this->lang->line('admin_lbl');?></h2>
        </div>
         <?php //pre($adminlist); ?>
        <?php if(!isset($_GET['show']) && @$_GET['show']!='yes'){ ?>        
            <ul class="folder">
                        <?php if(isset($adminlist)) {?>
                        <li>
                                <a href="<?php echo base_url();?>users/admininfo/<?php echo @$adminlist['id'] ?>?show=yes"><img alt="" src="<?php echo base_url();?>images/admin-big.png"><p><?php echo $this->lang->line('admin_title');?></p></a>
                        </li>
                        <?php } ?>
            </ul>
        <?php } else{ ?>
                <div class="tab-content-left">
                        <br/>    
                                <ul class="tab-field">
                                    <li><strong><?php echo $this->lang->line('admin_info_lable') ?></strong></li>    
                                    <li>
                                            <span><?php echo form_label($this->lang->line('admin_name_label'), 'userPassword','class="required"');?></span>
                                            <div class="input-divs">
                                               <span><b> <?php echo $adminlist['userName']; ?></b></span>
                                            </div>
                                   </li>
                                    <li>
                                             <span><?php echo form_label($this->lang->line('admin_company_label'),'newuserPassword','class="required"')?></span>
                                             <div class="input-divs">
                                                <span><b><?php echo $adminlist['companyName']; ?> </b></span>
                                             </div>
                                    </li>
                                    <li>
                                             <span><?php echo form_label($this->lang->line('email_lbl'), 'confirmPassword','class="required"');?></span>
                                             <div class="input-divs">
                                                <span><b><?php echo $adminlist['clientEmail']; ?></b></span>
                                             </div>
                                             
                                    </li>
                                    <li>
                                             <span><?php echo form_label($this->lang->line('admin_address_label'), 'confirmPassword','class="required"');?></span>
                                             <div class="input-divs">
                                                <span><b><?php echo $adminlist['clientAddress']; ?></b></span>
                                             </div>
                                             
                                    </li>
                                </ul>
                </div>
        
        <?php } ?>
    </div>
<?php $this->load->view('footer')?>
