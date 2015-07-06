<?php
session_start();
if(isset($_SESSION['name']))
{
    $text = $_POST['text'];
    $hand = $_POST['hand'];
    
        
    #ici c pour les smileys
    $text2 = str_replace(":)", "<img class='smileys' src='images/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' />", $text);
    $text3 = str_replace(":(", "<img class='smileys' src='images/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' />", $text2);
    $text4 = str_replace(";)", "<img class='smileys' src='images/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' />", $text3);
    $text5 = str_replace(":P", "<img class='smileys' src='images/smileys/tongue.gif' width='15' height='15' alt=':P' title=':P' />", $text4);
    $text6 = str_replace("S-)", "<img class='smileys' src='images/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' />", $text5);
    $text7 = str_replace(">(", "<img class='smileys' src='images/smileys/angry.gif' width='15' height='15' alt='>(' title='>('  />", $text6);
    $text8 = str_replace(":*)", "<img class='smileys' src='images/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' />", $text7);
    $text9 = str_replace(":D", "<img class='smileys' src='images/smileys/grin.gif' width='15' height='15' alt=':D' title=':D' />", $text8);
    $text10 = str_replace(":'(", "<img class='smileys' src='images/smileys/cry.gif' width='15' height='15' alt=':(' title=':(' />", $text9);
    $text11 = str_replace("=O", "<img class='smileys' src='images/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' />", $text10);
    $text12 = str_replace("=/", "<img class='smileys' src='images/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' />", $text11);
    $text13 = str_replace("8-)", "<img class='smileys' src='images/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' />", $text12);
    $text14 = str_replace(":-X", "<img class='smileys' src='images/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' />", $text13);
    $text15 = str_replace("O:]", "<img class='smileys' src='images/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' />", $text14);
    $text16 = str_replace(":f", "<img class='smileys' src='images/smileys/finger.gif' width='22' height='22' alt='O:]' title='O:]' />", $text15);
    if(strpos($text16, "http") === false)
    {
        $textfinal = $text16;
    }else{
        $text17 = explode(" ", $text16);
        $fim = false;
        for($i = 0; $i < sizeof($text17); $i++)
        {
            if(strpos($text17[$i], "http") === false)
            {
                $text18 = $text16;
                
            }else{
                $text18 = str_replace($text17[$i], "<a href=".$text17[$i].">".$text17[$i]."</a>", $text15);
                $fim = true;
            }
            if($fim) break;
        }
        $textfinal = $text18;
    }
    

    $fp = fopen("../convers/log".$hand.".html", 'a');
    switch($_SESSION['id_users'])
    {
        case 1:
            fwrite($fp, "<div class='msgln' style='color: blue;'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$textfinal."<br></div>");
            break;
        case 2:
            fwrite($fp, "<div class='msgln' style='color: fuchsia;'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$textfinal."<br></div>");
            break;
        case 3:
            fwrite($fp, "<div class='msgln' style='color: green;'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$textfinal."<br></div>");
            break;        
        case 5:
            fwrite($fp, "<div class='msgln' style='color: palevioletred;'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$textfinal."<br></div>");
            break;
        case 6:
            fwrite($fp, "<div class='msgln' style='color: #FF00FF;'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$textfinal."<br></div>");
            break;
    }
    #fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".$text15."<br></div>");
    fclose($fp);        
}
?>

