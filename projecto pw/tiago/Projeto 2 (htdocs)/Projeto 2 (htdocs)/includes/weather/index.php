<?php

include ("../json.php");


?>

<html>
<head>
</head>

<body>



<?php

$weather_key = "20eba6f1baeaa17b";

$url_weather = "http://api.wunderground.com/api/20eba6f1baeaa17b/geolookup/conditions/forecast/q/Portugal/Guimaraes.json";

$json_string = file_get_contents($url_weather);
$parsed_json = json_decode($json_string);
$location = $parsed_json->{'location'}->{'city'};
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$temp_icon = $parsed_json->{'current_observation'}->{'icon_url'};
echo "A temperatura actual em ${location} é: ${temp_c}ºC\n";
?>

</br>
<img src="<?= $temp_icon ?>" />

</body>

</html>