<?php
require_once 'phpQuery-onefile.php';
$arExclusion = array("/news-landing\r\n");
$arLinks = array();
$arItemLink = array();
$arPropsLinks = array();
$arId = array();
$count_pass = 0;
$file_array1 = file("categories.txt");
$file_array2 = file("categories_page.txt");
$file_array = array_merge($file_array1, $file_array2);
foreach ($file_array as $key_catalog => $link_child) {
    sleep(1);
    $html = file_get_contents('http://www.mvideo.ru' . rtrim($link_child));
    $document = phpQuery::newDocument($html);
    foreach ($document->find('.product-tile-title-link') as $key_index => $element_index) {
        sleep(10);
        $pq = pq($element_index);
        $arItemLink['item']['link_catalog'][$key_catalog][$key_index] = (($pq->attr('href') != "#") || (in_array($pq->attr('href'), $arExclusion))) ? $pq->attr('href') : "";
        $arItemLink['item']['name_catalog'][$key_catalog][$key_index] = ($pq->attr('title'));
    }
    foreach ($document->find('.product-price-current') as $key_index => $element_index) {
        sleep(10);
        $pq = pq($element_index);
        $arItemLink['item']['price'][$key_catalog][$key_index] = ($pq->text());
    }
    foreach ($document->find('.star-rating-reviews-qty') as $key_index => $element_index) {
        sleep(10);
        $pq = pq($element_index);
        $arItemLink['item']['num_rew'][$key_catalog][$key_index] = ($pq->text());
        $PEREV = strrev($arItemLink['item']['link_catalog'][$key_catalog][$key_index]);
        $delimiter = '-';
        $limit = 100;
        $KON = ARRAY();
        $KON = explode($delimiter, $PEREV);
        $arId["id"][$count_pass] = (strrev((array_shift($KON))));
        $arId["name"][$count_pass] = ($arItemLink['item']['name_catalog'][$key_catalog][$key_index]);
        $arId["nr"][$count_pass] = ($arItemLink['item']['num_rew'][$key_catalog][$key_index]);
        $arId["pr"][$count_pass] = ($arItemLink['item']['price'][$key_catalog][$key_index]);
        $arId["img"][$count_pass] = ($arItemLink['item']['image'][$key_catalog][$key_index]);
        if (preg_replace('#\(?(\w)\)?#s', '$1', $arId["nr"][$count_pass]) > 0) {
            $arId["id_name"][] = $arId["id"][$count_pass] . ";;" . $arId["name"][$count_pass] . ";;" .$arId["pr"][$count_pass] . ";;" . preg_replace('#\(?(\w)\)?#s', '$1', $arId["nr"][$count_pass]) . "\r\n";
     
}

        $count_pass++;
    }
file_put_contents('item.txt', $arId["id_name"], FILE_APPEND);  
unset($arId["id_name"]); 
}
//file_put_contents('item.txt', $arId["id_name"]);
sleep(10);
echo 'photoitem';
ob_flush();
flush();
require_once 'photoitem.php';
?>