<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="oneandsimple.co offers Global financial and administrative outsourcing services. A quality service based in an unique and simple principle. MAKE IT ONE. MAKE IT SIMPLE"  />
<meta name="keywords" content="One And Simple, oneandsimple, Numera, administrative outsourcing services, Global financial, Financial Management, Administrative management, Financial services, Adminsitrative services, Gestão Financeira, Gestão Administrativa, Contabilidade, MAKE IT ONE. MAKE IT SIMPLE" />
<title>Home</title>
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>javascript/modernizr.custom.79639.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<!--if internet not available-->
<!--<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-1.7.1.min.js"></script>-->
<!--end-->
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.validate-rules.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/common.js"></script>
<?php if($this->session->userdata('loggedInUser')) {?>
		<script type="text/javascript">
			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;
					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}
			$(function() {
				var dd = new DropDown( $('#dd') );
				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-5').removeClass('active');
				});
			});
			
			
			$(function() {
				var action = new DropDown( $('#action') );
				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-5').removeClass('active');
				});
			});
			
		$(document).ready(function(){
				
				$(".upload").colorbox({inline:true, width:"50%"});
					//Example of preserving a JavaScript event for inline calls.
					
				/*export_folder*/
				$(".exportfolder").colorbox({inline:true, width:"50%"});
				
				/*rename_file_form*/
				$(".showrename").colorbox({inline:true, width:"50%"});
				
				/*moove_file*/
				$(".file_move").colorbox({inline:true, width:"50%"});
				
					
				/*update file*/	
				$(".file_update").colorbox({inline:true, width:"50%",height:"80%"});	
				
				/*Preview file*/	
				$(".preview_file").colorbox({inline:true, width:"70%",height:"450px"});	
				
				$("#uploadbtnsubmit").click(function(){
					
					var folderval = $("#folderid option:selected").val();
					var fileval = $('#upld_file').val();
					if (folderval=='') {
						$('#folderidmsg').text("Select any one folder.");
						return false;
					}else if (fileval=='') {
						$('#filemsg').text("Select any file to upload.");
						//code
						return false;
					}else if(folderval=='' && fileval=='') {
						$('#bothfieldvaldat').text("Select any one folder and upload a file.");
						return false;
					}
					else {
						$('#folderidmsg').text('');
						$('#filemsg').text('');
						$('#bothfieldvaldat').text('');
						return true;}
					//$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"					}).text("Open this window again and this message will still be here.");
					//return false;
				});
				
				
				
				$("#del_file").click(function(){
					var option = $('#fieldid').val();
					if(option!=""){
						$.get('<?php echo base_url();?>users/deletegooglefile/'+option, function(data) {
						 $('#del_file_msg').css("display","block");
						 //$('#del_file_msg').toggle("slow");
							$('#del_file_msg').hide(3000, function () {
							$(this).remove();
						      });
						location.reload();
					       });
					}else{  $('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
					}
				});
				
				/*moove by id*/
				
				$(".file_move").click(function(){
					var option = $(this).attr('id');
					var oldprarenid =  $("#oldparentfolderid").val();
					//alert(option);
					$('#moovefileid').val(option);
					$('#oldparentid').val(oldprarenid);
				});
				
				
				/*Getfile content*/
				$(".file_update").click(function(){
					//alert($(this).attr('id'));	
					var option = $(this).attr('id');
					if(option!=""){
						$.get('<?php echo base_url();?>users/deleteget_google_file_contentgooglefile/'+option, function(data) {
						 //alert(data);
						 if(data){
								$('#showinnhtml').html(data);		
						 }else{
								$('#showinnhtml').append('<div id="loading-image"><img src="/images/icons/loader.gif" alt="Loading..." /></div>');
						 }
						 
						
					       });
					}else{  $('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
					}	
				});
				
				/*preview file form*/
				$(".preview_file").click(function(){
					//alert($(this).attr('id'));
					
					$("#preview_file").html('<div style="margin-left:250px;margin-top: 100px;"><img src="<?php echo base_url() ?>images/icons/loader.gif"/></div>');

					var option = $(this).attr('id');
					if(option!=""){
						$.get('<?php echo base_url();?>users/previewFile_drive/'+option, function(data) {
						 //alert(data);
							 					 
						 $('#preview_file').html(data);
								
						 
					       });
						
					}/*else{  $('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
					}*/
				});
				
				
				
				/*Show rename form*/
				$(".showrename").click(function(){
					//alert($(this).attr('id'));	
					var option = $(this).attr('id');
					if(option!=""){
						$.get('<?php echo base_url();?>users/get_google_renamefile/'+option, function(data) {
						 //alert(data);
						 $('#show_rename_file').html(data);						
					       });
					}/*else{  $('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
					}*/
				});
				
				
				/*Downloadfile*/
				$("#downloadfile").click(function(){
					var option = $('#fieldid').val();
					if(option!=""){
						$.get('<?php echo base_url();?>users/googdownloadfile/'+option, function(data) {
						// alert(data);
						 $('#show_rename_file').html(data);						
					       });
					}else{  $('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
					}
				});
				
				
				/*change*/
				$(".files").click(function(){
						var durl = $('#dlink').val();
						if (durl=='') {
							$('#del_file_msg').html('Please select any one file.');
						$('#del_file_msg').removeClass("alert-success");
						$('#del_file_msg').addClass("alert-error");
						$('#del_file_msg').css("display",'block');
						}else{
						     $("#downloadfile").attr("href",durl);		
						}
						
				});
				
				
				/*Change language*/
				$(".changelng").click(function(){
					var option = $(this).attr('id');
					if(option!=""){
						$.get('<?php echo base_url();?>users/changelaunguage/'+option, function(data) {
						location.reload();
					       });
					}
				});


		});
		
		function download_selected_files(){
	
				var fileArry = new Array();
				var i= 0;
				$('.files').each(function(){
					if($(this).hasClass('tabactive')){
						fileArry[i] = 	$(this).attr('id');
						i++;
					}
				});	
				
				if(!fileArry.length){
					alert("<?php echo $this->lang->line('header_warning_msg_slctfile');?>");
				}
				else{
					$setAttr=$("#downloadfile_abs").attr("href","<?php echo base_url();?>users/download_seledcted_file_zip/"+fileArry);	
				}
			
			}
	
		</script>
		
	<script>
	$(function () {
		$('nav li ul').hide().removeClass('fallback');
		$('nav li').hover(function () {
			$('ul', this).stop().slideToggle(200);
		});
	});
	
	function goForward()
	{
		window.history.forward()
	}
	function goBack()
	{
	window.history.back()
	}
	
	$("#show_div").mouseover(function() { $("#hello").css('visibility','visible'); });
	$("#hello").mouseover(function() { $("#hello").css('visibility','visible'); });
	$("#hello").mouseout(function() { $("#hello").css('visibility','hidden'); });
	</script>

<?php } else{ ?>
<script type="text/javascript" src="<?php echo base_url();?>javascript/placeholder.js"></script>
<?php } ?>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery-ui-timepicker-addon.js"></script>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url();?>javascript/fancybox/jquery.easing-1.3.pack.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/colorbox.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url();?>javascript/jquery.colorbox.js"></script>

<script>
/*Check folder avaiblitiy is exist or not*/		
<?php if(!$this->session->userdata('checkFold') && $this->session->userdata('loggedInUser')){	?>
	$(document).ready(function(){
		$.get('<?php echo base_url();?>users/checkfolderIsexistorNot');
	});
<?php } ?>	
	
</script>



</head>
<body>
<?php //echo var_dump($this->session->userdata('checkFold'));?>
<div class="wrapper"> <!---open wrapper div-->
	<?php  $filesmethod = $this->uri->segment(2); ?>
	<?php //pre($this->session->userdata); ?>
	<?php if($this->session->userdata('loggedInUser')) {?>
	<div class="header">
		<div class="logo"><a href="<?php echo base_url();?>users/alldocs"><img src="<?php echo base_url();?>images/logo-inner.png" alt="" /></a></div>
		<div class="header-right">
			<div class="wrapper-demo">
				<div id="dd" class="wrapper-dropdown-5" tabindex="1">
					<span>
						<?php if($this->session->userdata('fname') && $this->session->userdata('lname')) {?>
							<?php echo ucfirst($this->session->userdata('fname'));echo '&nbsp;'; echo ucfirst($this->session->userdata('lname'))?>
						<?php }else {?>
						
							<?php echo ucfirst($this->session->userdata('userName'))?>
						<?php } ?>
					</span>
					<img src="<?php echo base_url();?>uploads/users/<?php echo $this->session->userdata('userImage')?>" alt="" />
					<ul class="dropdown">
						<!--<li><a href="<?php echo base_url();?>users/profile"><i class="icon-user"></i><?php echo $this->lang->line('profile_title');?></a></li>-->
						<li><a href="<?php echo base_url();?>users/admininfo/"><i class="icon-cog"></i><?php echo $this->lang->line('admin_title');?></a></li>
						<li><a href="<?php echo base_url();?>users/changepassword"><i class="icon-cog"></i><?php echo $this->lang->line('changepwd_lable');?></a></li>
						<li><a href="<?php echo base_url();?>users/logout"><i class="icon-remove"></i><?php echo $this->lang->line('log_out');?></a></li>
					</ul>
				</div>
				<div style="text-align:right;margin-right:20px;">
						<!--<div style="float: right;width: 130px;margin-top: 8px;">-->
						<a href="javascript:void(0);" class="changelng" id="engish"><img src="<?php echo base_url() ?>images/icons/english_flagbig.png" title="English"/></a>
						&nbsp;<a href="javascript:void(0);" class="changelng" id="portugal"><img src="<?php echo base_url() ?>images/icons/portugal_flagbig.png" title="Portugu&#234;s"/></a>
						<!--</div>
						<div>
						   <a href="https://www.facebook.com/oneandsimple" title="Facebook" target="_blank"><img src="<?php echo base_url();?>images/facebook.png" title="Facebook"/></a>
						</div>-->
				</div>
			</div>
		</div>
        </div>
	<div class="main-contnt"> <!---open main contnt div-->
		<div class="top-menu">
			
			<ul>
				<li><a href="<?php echo base_url();?>users/alldocs"><img title="<?php echo $this->lang->line('home_label');?>" src="<?php echo base_url();?>images/home.png" alt="home" /></a></li>
				<li><a href="javascript:void(0)" onclick="goBack();"><img title="<?php echo $this->lang->line('previous_label');?>" src="<?php echo base_url();?>images/previous.png" alt="previous" /></a></li>
				<li><a class="distanc" href="javascript:void(0)" onclick="goForward();"><img title="<?php echo $this->lang->line('next_label');?>" src="<?php echo base_url();?>images/next.png" alt="next" /></a></li>
				<li><a href="<?php echo base_url();?>"><img title="<?php echo $this->lang->line('refresh_lable');?>" src="<?php echo base_url();?>images/refresh.png" alt="refresh" /></a></li>
				<li><a href="#login_form" class="upload"><img title="<?php echo $this->lang->line('Uploadfile_label');?>" src="<?php echo base_url();?>images/back.png" alt="upload" /></a>
				<!--<a class='inline' href="#login_form">Inline HTML</a>-->
				<li><a href="javascript:void(0)" id="show_div" class="action"><img title="<?php echo $this->lang->line('action_label');?>" src="<?php echo base_url();?>images/action.png" alt="action" /></a>
					<ul class="sub-menu">
						<li><a href="#export_folder" class="exportfolder" style="color:#0E0E0E;font-size: 12px" title="<?php echo $this->lang->line('export_folder_title');?>"><?php echo $this->lang->line('export_lable');?></a></li>
					</ul>
				</li>
				<?php if($filesmethod=='fileListing'){?>
				<li><a href="" id="downloadfile_abs" onclick="download_selected_files();"><img title="<?php echo $this->lang->line('downloadfiles_label');?>" src="<?php echo base_url();?>images/download.png" alt="back" /></a></li>
				<?php } ?>
                                 <?php if($this->session->userdata('userRoleId') == 3){ ?>
                           <li><a href="<?php echo base_url();?>users/notification"><img height="20px" width="20px" title="<?php echo $this->lang->line('notification');?>" src="<?php echo base_url();?>images/notification.png" alt="notification" />
                                    <div class="notify_count"><?php echo $unread_notification; ?><?php echo $this->lang->line('unread');?></div></a></li>
                                <?php } ?>
                                
			</ul>
			<div class="search_div">
				<form method="post" id="frontsearchform" action="<?php echo base_url() ?>search?post=search">
					<!--Tab 1 For Add basic client information-->
							
								 <?php echo form_input('searchvalue', set_value('search'),'class="top_search"');?>
								 <?php echo form_error('searchvalue'); ?>
								 <input value="<?php echo $this->lang->line('go');?>" class="gosearch" type="submit" name="btnsubmit" />
								 <a class="adv_search" href="<?php echo base_url();?>search/" style="font-size:12px;"><?php echo $this->lang->line('advanced_search');?></a>
							

				</form>
			</div>
			
		</div>
		<!---open Section div-->
		<div class="section"> 
			<!--div class="section-left">
				<ul class="left-menu">
				<li <?php if(@$selected=='recentdocs') { ?>class="recentactive"<?php } ?>><a href="<?php echo base_url();?>users/recentfolders"><span class="recent"></span><?php echo $this->lang->line('recent_docs');?></a></li>
				<li <?php if(@$selected=='alldocs') { ?>class="all-docsactive"<?php } ?>><a href="<?php echo base_url();?>users/alldocs"><span class="all-docs"></span><?php echo $this->lang->line('all_docs');?></a></li>
				<li  <?php if(@$selected=='searchactive') { ?>class="searchactive"<?php } ?>><a href="<?php echo base_url();?>search/"><span class="search"></span><?php echo $this->lang->line('search_lable');?></a></li>
				<li <?php if(@$selected=='adminactive') { ?>class="adminactive"<?php } ?>><a href="<?php echo base_url();?>users/admininfo/"><span class="admin"></span><?php echo $this->lang->line('admin_title');?></a></li>
				</ul>
			</div-->
	
	
	
		<!--light box html-->
		<!--<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
			<p>The inline option preserves bound JavaScript events and changes, and it puts the content back where it came from when it is closed.</p>
			<p><a id="click" href="#" style='padding:5px; background:#ccc;'>Click me, it will be preserved!</a></p>
			
			<p><strong>If you try to open a new Colorbox while it is already open, it will update itself with the new content.</strong></p>
			<p>Updating Content Example:<br />
			<a class="ajax" href="../content/ajax.html">Click here to load new content</a></p>
			</div>
		</div>-->
		<div style="display:none">
			<form id="login_form" method="post" action="<?php echo base_url();?>search/uploadfile" enctype="multipart/form-data">
				<?php ?>
				<br/>
				<ul class="tab-field">
						<?php //$folderarray=getviewfolderlist();
						      global $options;
						     $folderarray = walk_dir_folder_view($this->session->userdata('dbparentfolderid'),"",'viewadd');
						?>
						<li><i><strong>File upload</strong></i></li>
						<div id="bothfieldmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						<li>
							 <span><?php echo form_label('Folder Name :', 'folderid','class="required"');?><em>*</em></span>
							 <div class="input-divs">
							       <select name="folderid" id="folderid" class="popupselect" >
								    <option value = "">- Select -</option>
								    <?php echo $folderarray;?>
							       </select>
							 </div>
							 <div id="folderidmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						</li>
						<li>
						 <span><?php echo form_label('Image:','upld_file','class="required"')?></span>
							 <div class="input-divs">
							 <?php //echo form_upload('upld_file','id="upld_file"')?>
							 <input name="upld_file" id="upld_file" type="file" value=""/>
							 </div>
							 <div id="filemsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						 </li>
				</ul>
				<div class="input-radio" style="float:left">
						<input value="Submit" class="sign" type="submit" name="btnsubmit" id="uploadbtnsubmit">
				</div>
				
			</form>
		</div>
		<!--Preview file-->
		<div style="display:none">
				<form id="file_preview_form" method="post" action="<?php echo base_url();?>search/editgoglefile" enctype="multipart/form-data">
						<div id="preview_file">
							<div style="margin-left:250px;margin-top: 100px;">
								<img src="<?php echo base_url() ?>images/icons/loader.gif"/>
							</div>	
						</div>
				</form>
		</div>
		
		<!--edit file-->
		<div style="display:none">
			<form id="file_edit_form" method="post" action="<?php echo base_url();?>search/editgoglefile" enctype="multipart/form-data">
				<?php ?>
				<br/>
				<div id="showinnhtml"><div style="margin-left:250px;margin-top: 100px;"><img src="<?php echo base_url() ?>images/icons/loader.gif"/></div></div>
				
				
			</form>
		</div>
		<!--Rename file-->
		<div style="display:none">
			<form id="file_rename_form" method="post" action="<?php echo base_url();?>users/googlefilerename" enctype="multipart/form-data">
				<br/>
				<div id="show_rename_file"><div style="margin-left:250px;margin-top: 50px;"><img src="<?php echo base_url() ?>images/icons/loader.gif"/></div></div>
				<input type="hidden" value="<?php echo $this->uri->segment(3); ?>" name="urlfolderid" />
			</form>
		</div>
		
		<!--export folder-->
		<div style="display:none">
			<form id="export_folder" method="post" action="<?php echo base_url();?>users/downloadzip" enctype="multipart/form-data">
				<br/>
				<ul class="tab-field">
						<?php //$folderarray=getviewfolderlist();
						      //pre($folderarray);
						?>
						<?php //$folderarray=getviewfolderlist();
						     global $options;
						     $options = '';
						     $folderarray = walk_dir_folder_view($this->session->userdata('dbparentfolderid'),"",'export');
						     //pre($folderarray);
						?>
						<li><i><strong><?php echo $this->lang->line('export_folder_label');?></strong></i></li>
						<div id="bothfieldmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						<li>
							 <span><?php echo form_label($this->lang->line('export_folder_name_label'), 'folderid','class="required"');?><em>*</em></span>
							 <div class="input-divs">
							       <select name="folderid" id="exportfolderid" class="popupselect" >
								    <option value = "">- Select -</option>
								    <?php echo $folderarray;?>
							       </select>
							 </div>
							 <div id="folderidmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						</li>
				</ul>
				<div class="input-radio" style="float:left">
						<input value="<?php echo $this->lang->line('front_search_sbmt_label');?>" class="sign" type="submit" name="btnsubmit" id="exportbutton">
				</div>
				
			</form>
		</div>
		<!--move file-->
		<div style="display:none">
			<form id="moov_file" method="post" action="<?php echo base_url();?>users/googlemoovfile" enctype="multipart/form-data">
				<br/>
				<ul class="tab-field">
						<?php 
						     global $options;
						     $options = '';
						     $folderarray = walk_dir_folder_view($this->session->userdata('dbparentfolderid'),"",'viewmove');
						?>
						<li><i><strong><?php echo $this->lang->line('file_move_ajx_title'); ?></strong></i></li>
						<div id="bothfieldmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						<li>
							 <span><?php echo form_label($this->lang->line('export_folder_name_label'), 'folderid','class="required"');?><em>*</em></span>
							 <div class="input-divs">
							       <select name="folderid" id="moovefolderid" class="popupselect" >
								    <option value = "">- Select -</option>
								    <?php echo $folderarray ?>
							       </select>
							 </div>
							 <input type="hidden" id="moovefileid" name="moovfileid"/>
							 <input type="hidden" id="oldparentid" name="oldparentid"/>
							 <div id="folderidmsg" style="color:#931017;width:82%;text-align: right;font-size: 12px"></div>
						</li>
				</ul>
				<div class="input-radio" style="float:left">
						<input value="<?php echo $this->lang->line('front_search_sbmt_label'); ?>" class="sign" type="submit" name="btnsubmit" id="moovebutton">
				</div>
				
			</form>
		</div>
	
	<?php } ?>		
	
	
	
	
