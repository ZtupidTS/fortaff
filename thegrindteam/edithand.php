<?php
include "includes/header.php";
$myhand = mysql_query("select * from view_all where users_enable= '1' and id=".$_GET['hand']);
?>
<script>
function EditHandDb(id)
{
    var edit_hh_title = $('title_hand').value;
    var classification = $('classification').value;
    var edit_hh_iduser = $('idusers').value;
    var edit_hh_hand_temp = $('hand').value;
    var edit_hh_hand_temp1 = edit_hh_hand_temp.replace(/\&nbsp;/g,' ');
    var edit_hh_hand = edit_hh_hand_temp1.replace('<font color=#FFFFFF>',' ');

    var edit_hh_thinkingprocess = $('thinkingprocess').value;
    var edit_hh_image = $('image').value;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr=new XMLHttpRequest();
    }else{// code for IE6, IE5
            var xhr=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr.onreadystatechange=function()
    {
        if (xhr.readyState==4 && xhr.status==200)
        {
            if(xhr.responseText.trim().slice(0,2) == 'ok')
            {
                alert('Main accepté');
                window.location = "global.php";
            }else{
                alert(xhr.responseText);
            }
            //$("txtchange").innerHTML=xhr.responseText;                                
        }
    }
    xhr.open("POST","ajax/aj_verif_edithand.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send('id='+id+'&title='+edit_hh_title+'&iduser='+edit_hh_iduser+'&hand='+edit_hh_hand+'&thinkingprocess='+edit_hh_thinkingprocess+'&image='+edit_hh_image+'&class='+classification);
    //xhr.open("GET",'ajax/verif_inserthand.php?title='+hh_title+'&iduser='+hh_iduser+'&hand='+hh_hand+'&thinkingprocess='+hh_thinkingprocess+'&image='+hh_image,true);
    //xhr.send();

}
</script>

        <h1 class="titulo2">Editer la main</h1>
        <form id="form_table" method="POST" action="verif_main.php">
            <table>
                <?php
                while($db_myhand = mysql_fetch_array($myhand))
                {?>
                    <tr>
                        <td><label class="form_col" for="nome">Titre:</label></td>
                        <td>
                            <select name="classification" id="classification">
                                <?php
                                $class = mysql_query("SELECT * FROM classification");
                                while($db_class = mysql_fetch_array($class))
                                {
                                    if($db_class['id'] == $db_myhand['id_class'])
                                    {?>
                                        <option value="<?= $db_class['id'];?>" selected ><?= $db_class['nom'];?></option>
                                        <?php
                                    }else{?>
                                        <option value="<?= $db_class['id'];?>"><?= $db_class['nom'];?></option>
                                        <?php
                                    }
                                }?>
                            </select>
                            <input name="title_hand" id="title_hand" type="text" required maxlength="30" value="<?php echo $db_myhand['title'];?>"
                        </td>                        
                    </tr>
                    <tr>
                    <h3 style="text-align: center;">Choisir "HTML + Suits" et ensuite coller le contenu dans la boite de dialogue "main".</h3>
                        <iframe name="I1" FRAMEBORDER=0 scrolling=auto src="http://www.flopturnriver.com/converter2/converter.php" width="800" height="400"></iframe>
                    </tr>
                    <tr>
                        <td><label style="visibility: hidden" class="form_col" for="idusers">id users:</label></td>
                        <td><input value="<?php echo $_SESSION['id_users'];?>" readonly name="idusers" style="visibility: hidden" id="idusers" type="text" required maxlength="2"/></td>
                    </tr>

                    <tr>
                        <td><label class="form_col" for="hand">Main:</label></td>
                        <td><textarea name="hand" id="hand" type="text" required rows="5" cols="50"><?php echo $db_myhand['hand'];?></textarea></td>
                    </tr> 
                    <tr>
                        <td><label class="form_col" for="image">Image:</label></td>
                        <td><input name="image" id="image" type="text" value="<?php echo $db_myhand['image1'];?>"></textarea></td>
                    </tr>
                    <tr>
                        <td><label class="form_col" for="thinkingprocess">Thinking Process:</label></td>
                        <td><textarea name="thinkingprocess" id="thinkingprocess" type="text" required rows="5" cols="50"><?php echo $db_myhand['thinkingprocess'];?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><label class="form_col" for="soumettre"><a href="#" onclick="EditHandDb('<?php echo $_GET['hand'];?>')">Soumettre</a></label></td>
                    </tr>
                    <?php
                }?>
            </table>
        </form>   

 <?php
include "includes/footer.php";
?>

