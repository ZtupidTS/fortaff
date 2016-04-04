 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* TinyMCE Inclusion Class
*
* @package        CodeIgniter
* @subpackage    Libraries
* @category    WYSIWUG
* @author        WackyWebs.net - Tom Glover
* @link        http://codeigniter.com/user_guide/libraries/zip.html
*/

class Tinymce {
/*
* Create Head Code - this converts $mode value to TinyMCE editors
* $Mode is the mode TinyMCE runs in - Please view TinyMCE manual for more detail
* $Theme is this style of running, eg advance or basic, defult advance
* $ToolLoc is the vertical location of the toolbar, Defult = 'top'
* $ToolAligh is the Horizontal Location of the toolbar, DeFult = 'left'
* $Resizeabe - Can the Client resize it on there web page.
* use in controllers like so:
* $data ['head'] = $this->tinymce->createhead('mode','theme','toolbar loc','toolbar align','resizable')
*/
function Createhead($Mode = 'textareas', $Theme = 'advanced', $ToolLoc = 'Top', $ToolAlign = 'left', $Resizable = FALSE)
{
$ci =& get_instance();
$baseJs = $ci->config->item('base_url').'/js';
return <<<EOF

tinyMCE.init({
// General options
mode : "$Mode",
theme : "$Theme",
plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

// Theme options
theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
theme_advanced_toolbar_location : "$ToolLoc",
theme_advanced_toolbar_align : "$ToolAlign",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : $Resizable,

// Example word content CSS (should be your site CSS) this one removes paragraph margins
content_css : "css/word.css",

// Drop lists for link/image/media/template dialogs
template_external_list_url : "lists/template_list.js",
external_link_list_url : "lists/link_list.js",
external_image_list_url : "lists/image_list.js",
media_external_list_url : "lists/media_list.js",
}
});

EOF;
}
/*
* Create Text Box
* Does not have to use variable in creation as can just return textarea, without
* $FullCode - True = Outputs full text area codein form tag! False = just the Tag no
* Form Wrap - Defult = False
* $Methord - Post or Get - Required if FC=True - String
* $Action - Controller to Call on Submission - Required if FC=True - String - Can use
* URL Helper
* $data ['head'] = $this->tinymce->createhead('Fullcode','Methord','Action')
*/
function Textarea($FullCode = FALSE, $Methord = "POST", $Action = '')

{
if ($FullCode === TRUE){
$mce = "<form action=\"$Action\" method=\"$Methord\"></form>";
$mce .= "<textarea name=\"TinyMCE\" cols=\"30\" rows=\"50\"></textarea>";
$mce .= "<input name=\"Submit\" type=\"button\" value=\"Submit\">";
$mce .= "</form>";
return $mce ;// Outputs to view file - String
}else{
$mce = "<textarea name=\"TinyMCE\" cols=\"30\" rows=\"50\"></textarea>";
return $mce ;// Outputs to view file - String
}
}
}

?>
