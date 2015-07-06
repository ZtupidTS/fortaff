<?php
include "includes/header.php";
#$_SESSION['id_handview'] = $_GET['hand'];
?>
<?php
$myhand = mysql_query("select * from view_all where users_enable= '1' and id=".$_GET['hand']);
?>
</br>
</br>
</br>

<div>
    <table id="viewhand">
        <tr><td></td></tr>
        <?php
        while($db_myhand = mysql_fetch_array($myhand))
        {?>
            
            <tr class="linha_impar">
                <td>
                <?php
                echo $db_myhand['title'];
                ?>
                </td>
            </tr>
            <tr>
                <td>
                <?php
                echo $db_myhand['hand'].nl2br("\n");
                if($db_myhand['image1'] != "")
                {?>
                    <img src="<?php echo $db_myhand['image1'];?>" alt="Vilain" title="vilain" />
                    <?php echo nl2br("\n");
                }
                echo '<span style="color: blue";>'.$db_myhand['login'].'</span>';
                ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="color: green; font: bold; font-size: 15px;">Thinkingprocess:</span><br/>
                    <?php
                        echo $db_myhand['thinkingprocess'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php include 'includes/shoutbox.php';?>
                </td>
            </tr>
            <?php
            
        }?>
    </table>
</div>

<?php
include "includes/footer.php";
?>

