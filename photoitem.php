<?php
require_once 'phpQuery-onefile.php';
$arExclusion = array("/news-landing\r\n");
$arLinks = array();
$arItemLink = array();
$arPropsLinks = array();
$arId = array();
$file_array1 = file("categories.txt");
$file_array2 = file("categories_page.txt");
$file_array = array_merge($file_array1, $file_array2);
foreach ($file_array as $key_catalog => $link_child) {
    sleep(10);
    $html = file_get_contents('http://www.mvideo.ru' . rtrim($link_child));
    $document = phpQuery::newDocument($html);
    foreach ($document->find('.product-tile-title-link') as $key_index => $element_index) {
        sleep(10);
        $pq = pq($element_index);
        $arItemLink['item']['link_catalog'][$key_catalog][$key_index] = (($pq->attr('href') != "#") || (in_array($pq->attr('href'), $arExclusion))) ? $pq->attr('href') : "";
        $arId["lk"][$key_index] = ($arItemLink['item']['link_catalog'][$key_catalog][$key_index]);
        $arId["id_name"][$key_index] = $arId["lk"][$key_index] . "\r\n";
    }
}
file_put_contents('photoitem.txt', $arId["id_name"]);
sleep(10);
echo 'image';
ob_flush();
flush();
require_once 'image.php';
?>