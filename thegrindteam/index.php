<?php
include "includes/header.php";
?>
<!-- mettre ici notre image du header avec un div johnny -->


    <script type="text/javascript" language="javascript">
        function submitFormulaire()
        {
            document.login_formulaire.submit();
        }		
    </script>
    
    <form method="post" name="login_formulaire" id="login_formulaire" action="verif_login.php">
        <table style="alignment-adjust: center; text-align: center;">
            <tr>
                <td>Login:</td> 
                <td><input type="text" name="login" size="10" maxlength="30" value="<?php echo $login;?>" required class="form"></td>
            </tr>
            <tr>
                <td>Password:</td> 
                <td><input type="password" name="password" size="10" maxlength="30" value="<?php echo $password;?>" required class="form"></td>
            <tr>
            <tr>
                <td><a href="javascript:void(0)" onClick="submitFormulaire()">Entrer</a></td>                
            </tr>
        </table>					
    </form>
    <?php
    if($autologin)
    {
        ?>
        <script>
            submitFormulaire()
        </script>
        <?php
    }
    if(isset($_SESSION["mensagem"]))
    {
            ?>
            <script>
            var mensagem = '<?php echo $_SESSION['mensagem'];?>'; 
            alert(''+mensagem);
            </script>
            <?php
    }
    unset($_SESSION["mensagem"]);
    ?>

    
<?php
include "includes/footer.php";
?>