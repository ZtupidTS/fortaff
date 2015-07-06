<div id="handnum" name="handnum" style="visibility: hidden; display: none;">
    <?php 
        echo $_GET['hand'];
        #$numhand = $_GET['hand'];
    ?>
</div>
<div id="wrapper">
	<div id="menu">
		<p class="welcome">Nom: <?php echo $_SESSION['name'];?><b></b></p>
		<div style="clear:both"></div>
	</div>	
        <div id="chatbox" name="chatbox">
            <?php  
                if(file_exists("convers/log".$_GET['hand'].".html") && filesize("convers/log".$_GET['hand'].".html") > 0){  
                    $handle = fopen("convers/log".$_GET['hand'].".html", "r");  
                    $contents = fread($handle, filesize("convers/log".$_GET['hand'].".html"));  
                    fclose($handle);  
                    echo $contents;
                    $contents = "";
                }                
            ?>
        </div>
<!--        <div id="relogio" name="relogio">
        </div>-->
    
	<div name="message" >
		<input name="usermsg" type="text" id="usermsg" size="150" value="" onkeypress="if(event.keyCode==13){envoiMessage()}"/>
                <input name="submitmsg" type="submit" id="submitmsg" value="Envoi" onclick="envoiMessage()" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Smiley" onclick="showSmiley()" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Refresh Chat" onclick="loadLog()" />
        </div>
</div>
<div name="smileys" id="smileys" style="visibility: hidden; display: none;">
<ul>
    <li>
    <img class='smileys' src='images/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' />  :)
    </li>
    <li>
    <img class='smileys' src='images/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' />  :(
    </li>
    <li>
    <img class='smileys' src='images/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' />  ;)
    </li>
    <li>
    <img class='smileys' src='images/smileys/tongue.gif' width='15' height='15' alt=':P' title=':P' />  :P
    </li>
    <li>
    <img class='smileys' src='images/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' />  S-
    </li>
    <li>
    <img class='smileys' src='images/smileys/angry.gif' width='15' height='15' alt='>(' title='>('  />  >(
    </li>
    <li>
    <img class='smileys' src='images/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' />  :*)
    </li>
    <li>
    <img class='smileys' src='images/smileys/grin.gif' width='15' height='15' alt=':D' title=':D' />  :D
    </li>
    <li>
    <img class='smileys' src='images/smileys/cry.gif' width='15' height='15' alt=":'(" title=":'(" />  :'(
    </li>
    <li>
    <img class='smileys' src='images/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' />  =O
    </li>
    <li>
    <img class='smileys' src='images/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' />  =/
    </li>
    <li>
    <img class='smileys' src='images/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' />  8-)
    </li>
    <li>
    <img class='smileys' src='images/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' />  :-X
    </li>
    <li>
    <img class='smileys' src='images/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' /> O:]
    </li>
    <li>
    <img class='smileys' src='images/smileys/finger.gif' width='15' height='15' alt=':f' title=':f' /> :f
    </li>
</ul>
</div>
<!--<script type="text/javascript" src="../js/jquery.min.js"></script>-->
<script type="text/javascript">
// jQuery Document
function envoiMessage()
{
    var urlhand = $("handnum").innerHTML.trim();
    var mesorig = $("usermsg").value;
    var clientmsg = mesorig.replace(/\+/g, '%2B');
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr_send =new XMLHttpRequest();
    }else{// code for IE6, IE5
            var xhr_send =new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr_send.onreadystatechange=function()
    {
        if (xhr_send.readyState==4 && xhr_send.status==200)
        {
            $("usermsg").value = "";
            xhr_send = null;
        }
    }
    xhr_send.open("POST","includes/post.php",true);
    xhr_send.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr_send.send('text='+clientmsg+'&hand='+urlhand);
    return false;  
}
function loadLog()
{       
    var oldscrollHeight = $("chatbox").scrollHeight - 20; 
    //var urlhand2 = document.URL.split("=");
    var urlhand2 = $("handnum").innerHTML.trim();
    //alert(urlhand2);
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr_refresh=new XMLHttpRequest();
    }else{// code for IE6, IE5
            var xhr_refresh=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhr_refresh.onreadystatechange=function()
    {
//        alert("rtyuu"+xhr.readyState);
//        alert(''+xhr.status);
        if (xhr_refresh.readyState==4 && xhr_refresh.status==200)
        {
            //alert(xhr.responseText);
            $("chatbox").innerHTML = xhr_refresh.responseText;
            //Auto-scroll			
            var newscrollHeight = $("chatbox").scrollHeight - 20;
            if(newscrollHeight > oldscrollHeight)
            {
                $("chatbox").scrollTop = $("chatbox").scrollHeight;
            }
            xhr_refresh = null;
            //$("txtchange").innerHTML=xhr.responseText;                                
        }
    }
    //xhr_refresh.open("GET","convers/log"+urlhand2+".html",true);
    //xhr_refresh.send(); 
    xhr_refresh.open("POST","convers/log"+urlhand2+".html",true);
    xhr_refresh.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr_refresh.send('text=12');
    return false;
    
    
    //meu test
//    var dia_actual = new Date();
//                var tempo_restante = dia_actual.getTime();
//                var s_rest = tempo_restante / 1000;
//                var m_rest = s_rest / 60;
//                var h_rest = m_rest / 60;
//                var d_rest = h_rest / 24;
//
//                //agora arredondar os valores	
//                s_rest = Math.floor(s_rest % 60);
//                m_rest = Math.floor(m_rest % 60);
//                h_rest = Math.floor(h_rest % 24);
//                d_rest = Math.floor(d_rest);
//
//                var dias_que_faltam = 'Faltam '+d_rest+' dias '+h_rest+' horas '+m_rest+' minutos '+s_rest+' segundos para poder alterar e/ou eliminar equipas e atletas';
//
//                document.getElementById("relogio").innerHTML = dias_que_faltam;
}
setInterval (loadLog, 1000);//2500ms
function showSmiley()
{
    if($("smileys").style.visibility == "hidden")
    {
        $("smileys").style.display = "";
        $("smileys").style.visibility = "";
    }else{
        $("smileys").style.display = "none";
        $("smileys").style.visibility = "hidden";
    }    
}
</script>
