<?php
header("Content-Type: text/html; charset=utf-8");
ini_set("max_execution_time","0");
ini_set('memory_limit','-1');
$site_url = "http://www.mvideo.ru";
require_once 'phpQuery-onefile.php';
$photo_file_array = file("photoitem.txt");
foreach ($photo_file_array as $key_catalog => $link_child) {
    $html_i = file_get_contents($site_url . rtrim($link_child));
    $document = phpQuery::newDocument($html_i);
    echo 'pa6otaet o/';
    $document_i = phpQuery::newDocument($html_i);
    foreach ($document_i->find('ul.product-carousel.in-page li a.wrapper') as $key_index => $element_index) {
        $pq = pq($element_index);
        $arId["img"][$key_index] = (($pq->attr('href')));
        $arId["image"][$key_index] = ($arId["img"][$key_index]) . "\r\n";
    }
    file_put_contents('img.txt',$arId["image"],FILE_APPEND);
}
$img_file_array = file("img.txt");


foreach ($img_file_array as $key_catalog => $link_child) {
    sleep(2);
    $link_child = rtrim($link_child);
    $link = file_get_contents("http:" . $link_child);
    $PEREV = strrev($link_child); // выводит "!dlrow olleH"
    $delimiter = '/';
    $limit = 100;
    $KON = ARRAY();
    $KON = explode($delimiter,$PEREV);
    $name_img = strrev((array_shift($KON)));
    $document = phpQuery::newDocument($html);
    $PEREVname = $name_img;
    $delimitername = 'b';
    $limitname = 100;
    $KONname = ARRAY();
    $KONname = explode($delimitername,$PEREVname);
    $name_cat1 = (array_shift($KONname));
    mkdir("img/" . $name_cat1, 777);
    $path = 'img/' . $name_cat1 . "/" . $name_img;
    file_put_contents($path,$link);
}
sleep(10);
echo 'name';
ob_flush();
flush();
//require_once 'name.php';
?>