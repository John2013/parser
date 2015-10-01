<?
header('Content-Type: text/html ; charset="utf-8"');
$file = file_get_contents('file.txt'); 
$file = explode(chr(10), $file);
$delim = ту;

foreach ($file as $k => $v) {
	$url = "http://export.yandex.ru/inflect.xml?name=$v";
	$xml = simplexml_load_file($url);
	$original = $xml->original;
	$im = trim($xml->inflection[0]);
	$rod = trim($xml->inflection[1]);
	$dat = trim($xml->inflection[2]);
	$vin = trim($xml->inflection[3]);
	$tvor = trim($xml->inflection[4]);
	$predl = trim($xml->inflection[5]);

	echo $im.$delim.$rod.$delim.$dat.$delim.$vin.$delim.$tvor.$delim.$predl.chr(10);
	echo '<br />';
}
?>