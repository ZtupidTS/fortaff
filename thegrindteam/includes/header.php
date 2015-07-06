<?php
session_start();
require_once 'fonction/fonction.php';
$url_actual = recupera_url_atual();
if(isset($_SESSION['name']) && $_SESSION['name'] != "")
{
    $visibilitymenu = "block";
}else{
    if($url_actual != "index.php")
    {
        header('Location: index.php');
    }
    $visibilitymenu = "hidden";
}
#liaison a la DB
include 'connectDB.php';
#v?rifier si l'utilisateur s'est d?ja logger ou non
include 'cookie.php';
#aqui c'est pour récuperer la date de la dernière visite
if($url_actual != "index.php")
{

    if(!isset($_SESSION['lastvisit_db']))
    {
        $_SESSION['lastvisit'] = "1";
        mysql_query("UPDATE tgt_users SET lastvisit_old = lastvisit WHERE id = ".$_SESSION['id_users']);     
        $lastvisit = mysql_query("select * from tgt_users WHERE id = ".$_SESSION['id_users']);
        while($db_lastvisit = mysql_fetch_array($lastvisit))
        {
            $_SESSION['lastvisit_db'] = $db_lastvisit['lastvisit_old'];
        }
    }
    #ici je récupère les main a voir dans un array

    $scandir = scandir("convers");
    $id_convers = array('0');

    for($i=2;$i < count($scandir);$i++)
    {
        if(strtotime($_SESSION['lastvisit_db']) < filemtime("convers/".$scandir[$i]))
        {
            $id_convers_1 = str_replace("log", "", $scandir[$i]);
            $id_convers_2 = str_replace(".html", "", $id_convers_1);
            array_push($id_convers, $id_convers_2);
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>TheGrindTeam</title>
                <style type="text/css">
                /* For Mozilla only: create rounded corners */
                #box {
                  -moz-border-radius: 10px 10px 10px 10px;
                }
                </style>
                <link href="css/newcss.css" rel="stylesheet" type="text/css" name="css">
                
		<meta http-equiv="content-type" content="text/html;charset=iso-8892-2">
		<link rel="shortcut icon" href="../images/favicon.ico">
		<script type="text/javascript" language="javascript" src="js/prototype.js"></script>
                <script type="text/javascript" src="js/dropdownmenu.js"></script>
                <script type="text/javascript" language="javascript" src="js/InsertHandDb.js"></script>
                <script type="text/javascript" language="javascript" src="js/closesite.js"></script>
                <script type="text/javascript" language="javascript">                
                function CommentHand(hand)
                {
                    window.location = "viewhand.php?hand="+hand;
                }
                function Spoilerhand()
                {
                    if($("spoiler_id").style.visibility == "hidden")
                    {
                        $("spoiler_id").style.display = "";
                        $("spoiler_id").style.visibility = "";
                    }else{
                        $("spoiler_id").style.display = "none";
                        $("spoiler_id").style.visibility = "hidden";
                    }
                }
                </script>
		<script type="text/javascript" language="javascript" src="js/pagina_tabela_init.js"></script>
		<script type="text/javascript" language="javascript" src="js/pagina_tabela.js"></script>
	</head>
	
	<body>
            
        <div class="estrutura">	
            <div id="banner">
                &nbsp;
            </div>
<div id="menu_vis" >                   

    <ul class="menu" id="menu" style="visibility: <?php echo $visibilitymenu;?>">
        <!-- ici c'est le nom du user ou par date -->
        <li><a href="global.php" class="menulink">Home</a></li>
        <li><a href="inserthand.php" class="menulink">Insert Hand</a></li>
        <li>
            <a href="#" class="menulink" >All Mains</a>
            <ul>
                <?php
                $dball_query = "select id, id_users, title, hand, date, YEAR(date) as dateyear from view_all GROUP BY YEAR(date) ORDER BY date";
                $dballdate_result = mysql_query($dball_query);
                if(mysql_num_rows($dballdate_result) > 0)
                {
                    while($db_alldates = mysql_fetch_array($dballdate_result))
                    { ?>
                        <li>
                            <!-- ici c'est les années -->
                                <a href="#" class="sub"><?php echo $db_alldates['dateyear'];?></a>
                                <ul>
                                    <?php
                                    $dballmonth_query = "select id, id_users, title, hand, date, MONTH(date) as datemonth from view_all where YEAR(date)=".$db_alldates['dateyear']." GROUP BY MONTH(date) ORDER BY date";
                                    $db_allmonth_result = mysql_query($dballmonth_query);
                                    if(mysql_num_rows($db_allmonth_result) > 0)
                                    {       
                                        $i = 0;
                                        while($db_alldatem = mysql_fetch_array($db_allmonth_result))
                                        {
                                            #ici les mois
                                            if($i == 0)
                                            {?>
                                                <li class="topline"><a href="#" class="sub"><?php echo $db_alldatem['datemonth'];?></a>
                                                <?php
                                                $i=1;
                                            }else{?>
                                                <li><a href="#" class="sub"><?php echo $db_alldatem['datemonth'];?></a>
                                                <?php
                                            }?>
                                            <ul>
                                                <!-- aqui a qunzena -->
                                                <?php
                                                $quinz1_query = "select id, id_users, title, hand, date from view_all where YEAR(date)=".$db_alldates['dateyear']." AND MONTH(date)=".$db_alldatem['datemonth']." AND DAY(date) >= 1 and DAY(date) < 16 ORDER BY date DESC";
                                                $db_quinz1_result = mysql_query($quinz1_query);
                                                $quinz = 0;
                                                if(mysql_num_rows($db_quinz1_result) > 0)
                                                { 
                                                    ?>
                                                    <li class="topline"><a href="#" class="sub">1 au 15</a>
                                                    <?php
                                                    $quinz = 1;                                                    
                                                ?>
                                                    <ul>
                                                        <?php
                                                        $dballtitle_query = "select id, id_users, title, hand, login, date, classification from view_all where YEAR(date)=".$db_alldates['dateyear']." AND MONTH(date)=".$db_alldatem['datemonth']." AND DAY(date) >= 1 and DAY(date) < 16 ORDER BY date DESC";
                                                        $db_alltitle_result = mysql_query($dballtitle_query);
                                                        if(mysql_num_rows($db_alltitle_result) > 0)
                                                        {
                                                            #ici les mains
                                                            $l=0;
                                                            while($db_alltitle = mysql_fetch_array($db_alltitle_result))
                                                            {
                                                                if($l==0)
                                                                {?>
                                                                    <li class="topline"><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                                    <?php
                                                                    $l=1;
                                                                }else{?>
                                                                    <li><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }?>
                                                    </ul>
                                                </li>
                                                <?php
                                                }
                                                #deuxieme quinzaine
                                                $quinz2_query = "select id, id_users, title, hand, date from view_all where YEAR(date)=".$db_alldates['dateyear']." AND MONTH(date)=".$db_alldatem['datemonth']." AND DAY(date) > 15 ORDER BY date DESC";
                                                $db_quinz2_result = mysql_query($quinz2_query);
                                                if(mysql_num_rows($db_quinz1_result) > 0)
                                                { 
                                                    if($quinz == 1)
                                                    {?>
                                                        <li><a href="#" class="sub"> 15+</a>
                                                        <?php
                                                    }else{?>
                                                        <li class="topline"><a href="#" class="sub"> 15+</a>
                                                        <?php
                                                    }
                                                    ?>
                                                    <ul>
                                                        <?php
                                                        $dballtitle_query = "select id, id_users, title, hand, login, date, classification from view_all where YEAR(date)=".$db_alldates['dateyear']." AND MONTH(date)=".$db_alldatem['datemonth']." AND DAY(date) > 15 ORDER BY date DESC";
                                                        $db_alltitle_result = mysql_query($dballtitle_query);
                                                        if(mysql_num_rows($db_alltitle_result) > 0)
                                                        {
                                                            #ici les mains
                                                            $l=0;
                                                            while($db_alltitle = mysql_fetch_array($db_alltitle_result))
                                                            {
                                                                if($l==0)
                                                                {?>
                                                                    <li class="topline"><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                                    <?php
                                                                    $l=1;
                                                                }else{?>
                                                                    <li><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }?>
                                                    </ul>
                                                </li>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                            </li>
                                            <?php
                                        }
                                    }?>
                                </ul>

                        </li>
                        <?php
                    }
                }?>
            </ul>
        </li>
        <li>
            <a href="#" class="menulink" >Classifications</a>
            <ul>
                <?php
                $dball_query = "select * from view_all GROUP BY classification ORDER BY classification";
                $dballdate_result = mysql_query($dball_query);
                if(mysql_num_rows($dballdate_result) > 0)
                {
                    while($db_alldates = mysql_fetch_array($dballdate_result))
                    { ?>
                        <li>
                            <!-- ici c'est les années -->
                                <a href="#" class="sub"><?php echo $db_alldates['classification'];?></a>
                                <ul>
                                    <?php
                                    $dballmonth_query2 = "select id, id_users, title, hand, date, classification, YEAR(date) as dateyear from view_all where id_class = ".$db_alldates['id_class']." GROUP BY YEAR(date) ORDER BY date DESC";
                                    $db_allmonth_result2 = mysql_query($dballmonth_query2);
                                    if(mysql_num_rows($db_allmonth_result2) > 0)
                                    {       
                                        $i = 0;
                                        while($db_alldatem = mysql_fetch_array($db_allmonth_result2))
                                        {
                                            #ici les mois
                                            if($i == 0)
                                            {?>
                                                <li class="topline"><a href="#" class="sub"><?php echo $db_alldatem['dateyear'];?></a>
                                                <?php
                                                $i=1;
                                            }else{?>
                                                <li><a href="#" class="sub"><?php echo $db_alldatem['dateyear'];?></a>
                                                <?php
                                            }?>
                                            <ul>
                                                <?php
                                                $dballtitle_query = "select id, id_users, title, hand, login, date, classification from view_all where id_class = ".$db_alldates['id_class']." AND YEAR(date)=".$db_alldatem['dateyear']." ORDER BY date DESC";
                                                $db_alltitle_result = mysql_query($dballtitle_query);
                                                if(mysql_num_rows($db_alltitle_result) > 0)
                                                {
                                                     $l=0;
                                                    while($db_alltitle = mysql_fetch_array($db_alltitle_result))
                                                    {
                                                        if($l==0)
                                                        {?>
                                                            <li class="topline"><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                            <?php
                                                            $l=1;
                                                        }else{?>
                                                            <li><a href="#" onclick="CommentHand('<?php echo $db_alltitle['id'];?>')"><?php echo "[".$db_alltitle['login']."] ".$db_alltitle['title'];?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                }?>
                                            </ul>
                                            </li>
                                            <?php
                                        }
                                    }?>
                                </ul>

                        </li>
                        <?php
                    }
                }?>
            </ul>
        </li>
        <br/>
        <br/>
        <br/>
        <?php
        // ici c'est pour le nom de l'utilisateurs
        $dbusers_query = "select * from view_all GROUP BY id_users";
        $dbusers_result = mysql_query($dbusers_query);
        $numberuser = 1;
        while($db_users = mysql_fetch_array($dbusers_result))
        { 
            if($numberuser == 5)
            {
                ?>
                </br>
                </br>
                </br>
                <?php
            }
            ?>
            <li><a href="#" class="menulink"><?php echo $db_users['login'];?></a>
                <ul>
                    <?php
                    $dbdate_query = "select id, id_users, title, hand, date, YEAR(date) as dateyear from view_all where id_users=".$db_users['id_users']." GROUP BY YEAR(date) ORDER BY date";
                    $dbdate_result = mysql_query($dbdate_query);
                    if(mysql_num_rows($dbdate_result) > 0)
                    {
                        while($db_datey = mysql_fetch_array($dbdate_result))
                        { ?>
                            <li>
                                <!-- ici c'est les années -->
                                <a href="#" class="sub"><?php echo $db_datey['dateyear'];?></a>
                                <ul>
                                    <?php
                                    $dbmonth_query = "select id, id_users, title, hand, date, MONTH(date) as datemonth from view_all where id_users=".$db_users['id_users']." AND YEAR(date)=".$db_datey['dateyear']." GROUP BY MONTH(date) ORDER BY date";
                                    $dbmonth_result = mysql_query($dbmonth_query);
                                    if(mysql_num_rows($dbmonth_result) > 0)
                                    {       
                                        $i = 0;
                                        while($db_datem = mysql_fetch_array($dbmonth_result))
                                        {
                                            #ici les mois
                                            if($i == 0)
                                            {?>
                                                <li class="topline"><a href="#" class="sub"><?php echo $db_datem['datemonth'];?></a>
                                                <?php
                                                $i=1;
                                            }else{?>
                                                <li><a href="#" class="sub"><?php echo $db_datem['datemonth'];?></a>
                                                <?php
                                            }?>
                                            <ul>
                                                <!-- premiere quinz -->
                                                <?php
                                                $quinz1_query = "select id, id_users, title, hand, date from view_all where YEAR(date)=".$db_datey['dateyear']." AND MONTH(date)=".$db_datem['datemonth']." AND DAY(date) >= 1 and DAY(date) < 16 AND id_users=".$db_users['id_users']." ORDER BY date";
                                                $db_quinz1_result = mysql_query($quinz1_query);
                                                $quinz = 0;
                                                if(mysql_num_rows($db_quinz1_result) > 0)
                                                { 
                                                    ?>
                                                    <li class="topline"><a href="#" class="sub">1 au 15</a>
                                                    <?php
                                                    $quinz = 1;                                                    
                                                ?>
                                                    <ul>
                                                        <?php
                                                        $dbtitle_query = "select id, id_users, title, hand, date from view_all where id_users=".$db_users['id_users']." AND YEAR(date)=".$db_datey['dateyear']." AND MONTH(date)=".$db_datem['datemonth']." AND DAY(date) >= 1 and DAY(date) < 16 ORDER BY date DESC";
                                                        $dbtitle_result = mysql_query($dbtitle_query);
                                                        if(mysql_num_rows($dbtitle_result) > 0)
                                                        {
                                                             $l=0;
                                                            while($db_title = mysql_fetch_array($dbtitle_result))
                                                            {
                                                                if($l==0)
                                                                {?>
                                                                    <li class="topline"><a href="#" onclick="CommentHand('<?php echo $db_title['id'];?>')"><?php echo $db_title['title'];?></a></li>
                                                                    <?php
                                                                    $l=1;
                                                                }else{?>
                                                                    <li><a href="#" onclick="CommentHand('<?php echo $db_title['id'];?>')"><?php echo $db_title['title'];?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }?>
                                                    </ul>
                                                </li>
                                                <?php
                                                }?>
                                                <!-- 2eme quinz -->
                                                <?php
                                                $quinz3_query = "select id, id_users, title, hand, date from view_all where YEAR(date)=".$db_datey['dateyear']." AND MONTH(date)=".$db_datem['datemonth']." AND DAY(date) > 15 AND id_users=".$db_users['id_users']." ORDER BY date DESC";
                                                $db_quinz3_result = mysql_query($quinz3_query);
                                                if(mysql_num_rows($db_quinz3_result) > 0)
                                                { 
                                                    if($quinz == 1)
                                                    {?>
                                                        <li><a href="#" class="sub"> 15+</a>
                                                        <?php
                                                    }else{?>
                                                        <li class="topline"><a href="#" class="sub"> 15+</a>
                                                        <?php
                                                    }?>
                                                    <ul>
                                                        <?php
                                                        $dbtitle_query = "select id, id_users, title, hand, date from view_all where id_users=".$db_users['id_users']." AND YEAR(date)=".$db_datey['dateyear']." AND MONTH(date)=".$db_datem['datemonth']." AND DAY(date) > 15 ORDER BY date DESC";
                                                        $dbtitle_result = mysql_query($dbtitle_query);
                                                        if(mysql_num_rows($dbtitle_result) > 0)
                                                        {
                                                             $l=0;
                                                            while($db_title = mysql_fetch_array($dbtitle_result))
                                                            {
                                                                if($l==0)
                                                                {?>
                                                                    <li class="topline"><a href="#" onclick="CommentHand('<?php echo $db_title['id'];?>')"><?php echo $db_title['title'];?></a></li>
                                                                    <?php
                                                                    $l=1;
                                                                }else{?>
                                                                    <li><a href="#" onclick="CommentHand('<?php echo $db_title['id'];?>')"><?php echo $db_title['title'];?></a></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }?>
                                                    </ul>
                                                </li>
                                                <?php 
                                                }?>
                                            </ul>
                                            </li>
                                            <?php
                                        }
                                    }?>
                                </ul>
                            </li>                        
                            <?php
                        }
                    }?>
                </ul>
            </li>	
            <?php
            $numberuser = $numberuser +1;
        }?>
    </ul>
<script type="text/javascript">
    var menu=new menu.dd("menu");
    menu.init("menu","menuhover");
</script>
</div> 
<br/>
<br/>
<br/>   
<br/> 
<br/>
<br/>
<br/>
<br/>