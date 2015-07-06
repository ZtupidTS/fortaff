<?php
include "includes/header.php";


$all_hands = mysql_query("select * from view_all where users_enable= '1' ORDER BY date DESC");
?>
<script>
function EditHand(hand)
{
    window.location = "edithand.php?hand="+hand;
}
function Deletehand(handnum)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        var xhr_delete =new XMLHttpRequest();
    }else{// code for IE6, IE5
        var xhr_delete =new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr_delete.onreadystatechange=function()
    {
//                            alert("rtyuu"+xhr.readyState);
//                            alert(''+xhr.status);
        if (xhr_delete.readyState==4 && xhr_delete.status==200)
        {
            alert(xhr_delete.responseText);
            location.reload();
        }
    }
    xhr_delete.open("POST","ajax/aj_verif_deletehand.php",true);
    xhr_delete.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr_delete.send('hand='+handnum);    
}
</script>
<div>
    <table id="results">
        <tr><td></td></tr>
        <?php
        while($db_allhands = mysql_fetch_array($all_hands))
        {?>
            
            <tr class="linha_impar">
                <td>
                <?php
                echo "[".$db_allhands['classification']."] ".$db_allhands['title'];
                if(file_exists("convers/log".$db_allhands['id'].".html"))
                {
                    ?>
                    <img src="images/accept.png" alt="Commentaire" title="Commentaire" width='15' height='15' />
                    <?php
                }
                if(isset($id_convers))
                {
                    if(in_array($db_allhands['id'], $id_convers))
                    {
                        ?>
                        <span style="text-decoration: blink; color: red;">New comment!!</span>
                        <?php
                    }
                }
                ?>
                </td>
            </tr>
            <tr>
                <td>
                <?php
                echo $db_allhands['hand'].nl2br("\n");
                if($db_allhands['image1'] != "")
                {?>
                    <img src="<?php echo $db_allhands['image1'];?>" alt="Vilain" title="vilain" />
                    <?php echo nl2br("\n");
                }
                echo '<span style="color: blue";>'.$db_allhands['login'].'</span>';
                ?>
                <br/>
                <a href="#" onclick="CommentHand('<?php echo $db_allhands['id'];?>')">Comment</a>
                <?php
                if($_SESSION['name'] == $db_allhands['login'])
                {
                    ?>
                    <a href="#" onclick="EditHand('<?php echo $db_allhands['id'];?>')">Edit</a>
                    <a href="#" onclick="Deletehand('<?php echo $db_allhands['id'];?>')">Delete</a>
                    <?php                    
                }
                ?>
                </td>
            </tr>
            <tr>
                <td style="border-left: none; border-right: none;"></td>
            </tr>
            <?php
            
        }?>
    </table>
</div>

<?php
include "includes/paginacao_tabela.php";
include "includes/footer.php";
?>