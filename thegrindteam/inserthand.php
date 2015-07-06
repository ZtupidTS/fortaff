<?php
include "includes/header.php";
?>

        <h1 class="titulo2">Insert Hand</h1>
        <form id="form_table" method="POST" action="verif_main.php">
            <table>
                <tr>
                    <td><label class="form_col" for="nome">Title:</label></td>
                    <td>
                        <select name="classification" id="classification">
                            <?php
                            $class = mysql_query("SELECT * FROM classification");
                            while($db_class = mysql_fetch_array($class))
                            {?>
                                    <option value="<?= $db_class['id'];?>"><?= $db_class['nom'];?></option>
                                    <?php
                            }?>
                        </select>
                        <input name="title_hand" id="title_hand" type="text" required maxlength="60" size="50">
                    </td>
                </tr>
                <tr>
                <h3 style="text-align: center;">Choose "HTML + Suits" and pasta in "Hand".</h3>
                    <iframe name="I1" FRAMEBORDER=0 scrolling=auto src="http://www.flopturnriver.com/converter2/converter.php" width="800" height="400"></iframe>
                </tr>
                <tr>
                    <td><label style="visibility: hidden" class="form_col" for="idusers">id users:</label></td>
                    <td><input value="<?php echo $_SESSION['id_users'];?>" readonly name="idusers" style="visibility: hidden" id="idusers" type="text" required maxlength="2"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <h5>Para inserir uma mão é mais facil com o hem2</h5>
                        <h5>Clic direito na mão e escolher view, em baixo a direita escolher html e depois copye colar onde diz Hand</h5>
                        <h5>Para falar inserir aqui no campo hand "."</h5>
                    </td>
                </tr>
                <tr>
                    <td><label class="form_col" for="hand">Hand:</label></td>
                    <td><textarea name="hand" id="hand" type="text" required rows="5" cols="50"></textarea></td>
                </tr> 
                <tr>
                    <td></td>
                    <td>
                        <h5>Para inserir uma imagem usar o gyazoo, e depois quando o gyazoo abre clic direito e copiar endereço da imagem</h5>
                        <h5>Colar isso onde diz Image</h5>
                    </td>
                </tr>
                <tr>
                    <td><label class="form_col" for="image">Image:</label></td>
                    <td><input name="image" id="image" type="text" size="65"></textarea></td>
                </tr>                
                <tr>
                    <td><label class="form_col" for="thinkingprocess">Thinking Process:</label></td>
                    <td><textarea name="thinkingprocess" id="thinkingprocess" type="text" required rows="10" cols="50">VPIP PFR 3bet% Hands:&#10;&#10;Preflop:&#10;&#10;Flop:&#10;&#10;Turn:&#10;&#10;River:&#10;</textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label class="form_col" for="soumettre"><a href="#" onclick="InsertHandDb()">Insert</a></label></td>
                </tr>
            </table>
        </form>   

 <?php
include "includes/footer.php";
?>