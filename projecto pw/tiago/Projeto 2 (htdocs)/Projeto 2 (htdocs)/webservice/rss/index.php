<?php

function  iconv_utf2iso2($string)
{
	return iconv("UTF-8", "ISO-8859-1//IGNORE", $string);
}

$url = "http://news.google.co.uk/news?ned=en_uk&q=olympics&num=6&scoring=d&output=rss&topic=s";

//com proxy
// $opts = array('http' => array('proxy' => 'tcp://proxy.uminho.pt:3128', 'request_fulluri' => true)); //'tcp://127.0.0.1:8080'
// $context = stream_context_create($opts);
$data = file_get_contents($url, false, getConfigProxyContext());
$rss = simplexml_load_string(utf8_encode($data));


//sem proxy
// $rss = simplexml_load_file(utf8_encode($url));

$information = $rss->xpath("/rss/channel");
$image = $rss->xpath("/rss/channel/image");
$items = $rss->xpath("/rss/channel/item");

?>
<html>
    <head>
        <title>RSS</title>
    </head>
    <body>
        <div class="rss">		
            <span class="noticia">
            </span>
        </div>
        <? foreach ($items as $item) : ?>
        <div class="noticia">
            <div>
				<h4><?= $item->pubDate[0] ?> </h4>
				<a href="<?= $item->link[0] ?>" ><?= utf8_decode($item->title[0]) ?> </a>
			</div>
        </div>	
        <? endforeach ?>
		<img style="width:70%;" src="<?= $image[0]->url[0]?>" title="Google RSS"?>

    </body>
</html>