<?php $this->load->view('header')?>
    <div class="section-right">
        <div class="headind">
          <h2><?php echo $title; ?></h2>
        </div>
        <?php //pr($user_folders_list);?>
        <?php //pre($visiblefolders);?>
        <?php //pre($recentdoclist);?>
        
        <ul class="folder">
        <?php if(count($recentdoclist)>0) {?>
        <?php //foreach($visiblefolders as $folders) {?>
            <?php //foreach($user_folders_list as $googlefolders) {?>
                <?php foreach($recentdoclist as $recentfolder) {?>
                    <?php //if($googlefolders['id']==$recentfolder['doc_id']){ ?>
                        <?php //if($folders['googleFolderName']==$googlefolders->title){ ?>
                            <?php //if(@$folders[0]->Viewfolder=='accept'){ ?>    
                                <?php if($recentfolder['doc_type']=='application/vnd.google-apps.folder'){ ?>
                                    <li><a href="<?php echo base_url();?>users/recentfiles/<?php echo $recentfolder['doc_id']; ?>"><img alt="" src="<?php echo base_url();?>images/all-docs-big.png"><p><?php echo $recentfolder['title']; ?></p></a>
                                    </li>
                                <?php } ?>
                            <?php //} ?>
                        <?php //} ?>
                    <?php //} ?>
                <?php } ?>    
            <?php //} ?>
        <?php //} ?>
        <?php } else { ?>
            <div class="alert-error"><?php echo $this->lang->line('no_found_display');?></div>
        <?php } ?>
        </ul>
         <?php echo $links; ?>
    </div>
<?php $this->load->view('footer')?>
