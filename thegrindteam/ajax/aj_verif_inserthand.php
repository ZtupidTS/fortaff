<?php
include '../includes/connectDB.php';
include '../fonction/fonction.php';

$iduser = control_post($_POST['iduser']);
$title = control_post($_POST['title']);
$hand = control_post($_POST['hand']);
$thinkingprocess = control_post($_POST['thinkingprocess']);
$image = $_POST['image'];
$class = $_POST['class'];

$stringempty = true;
$hand_final = "";


if($iduser == "")
{
    $stringempty = false;
    $mensagem = "Verifier id user";
}

if($stringempty && $title == "")
{
    $stringempty = false;
    $mensagem = "Insert title";
}

if($stringempty && $hand == "")
{
    $stringempty = false;
    $mensagem = "Insert hand";
    $hand_final = $hand;
}else{
    if($hand == ".")
    {
        $hand_final = $hand;        
    }else
    {
    
        $hm2 = true;
        if(strpos($hand, "<strong>Results:") === false)
        {
            $hm2 = false;
            if(strpos($hand, "Final Pot") === false)
            {
                $hand_split = explode("Results", $hand);
            }else{            
                $hand_split = explode("Final Pot", $hand);
            }        
        }else{
            $hand_split = explode("<strong>Results:", $hand);                
        }
        #$hand_split = explode("<strong>Results:", $hand);
        $spoiler = '<button type="button" onclick="Spoilerhand()">Spoiler</button><span id="spoiler_id" name="spoiler_id" style="visibility: hidden; display: none;">';
        if($hm2)
        {
            $hand_final = $hand_split[0] . $spoiler . "</br><strong>Results:" . $hand_split[1] . "</span>";
        }else{
            $hand_final = $hand_split[0] . $spoiler . "Results" . $hand_split[1] . "</span>";
        } 
    }
}

if($stringempty && $thinkingprocess == "")
{
    $stringempty = false;
    $mensagem = "Insert thinking process";
}

if($stringempty)
{
    mysql_query("INSERT INTO tgt_posthands (id_users, title, hand, thinkingprocess, image1, image2, date, enable, id_class) VALUES ('$iduser', '$title', '$hand_final', '$thinkingprocess', '$image', '', now(), '1', '$class')", $conexao);
    #echo mysql_errno($conexao) . "." . mysql_error($conexao);
    if(mysql_affected_rows() > 0)
    {
        mysql_close($conexao);
        echo 'ok';
    }else{
        mysql_close($conexao);
        echo "Hand no insert, speak with administrator";
    }
}else{
    mysql_close($conexao);
    echo $mensagem;
}
?>        