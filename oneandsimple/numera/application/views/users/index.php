<?php $this->load->view('header')?>
    <div class="section-right">
            <ul class="folder">
                        <li><a href="<?php echo base_url();?>users/recentdocs"><img alt="" src="<?php echo base_url();?>images/recent-big.png"><p><?php echo $this->lang->line('recent_docs');?></p></a>
                        </li>
                        <li><a href="<?php echo base_url();?>users/alldocs"><img alt="" src="<?php echo base_url();?>images/all-docs-big.png"><p><?php echo $this->lang->line('all_docs');?></p></a>
                        </li>
                        <li><a href="<?php echo base_url();?>search"><img alt="" src="<?php echo base_url();?>images/search-big.png"><p><?php echo $this->lang->line('search_title');?></p></a>
                        </li>
                        <li><a href="<?php echo base_url();?>users/admininfo/"><img alt="" src="<?php echo base_url();?>images/admin-big.png"><p><?php echo $this->lang->line('admin_title');?></p></a>
                        </li>
            </ul>
    </div>
<?php $this->load->view('footer')?>
