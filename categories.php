<?php
header("Content-Type: text/html; charset=utf-8");
ini_set("max_execution_time", "0");
ini_set('memory_limit', '-1');
ob_start();
require_once 'phpQuery-onefile.php';
$arExclusion = array("/news-landing\r\n", "/nam-nevseravno\r\n", "/company\r\n", "http://invest.mvideo.ru\r\n", "http://job.mvideo.ru\r\n", "/eco\r\n", "/fund\r\n", "/rent\r\n", "/contacts\r\n", "/how-to-buy\r\n", "/pamyatka\r\n", "/pickup\r\n", "/catalog\r\n", "/deliverypage\r\n", "http://www.mvideo-bonus.ru\r\n", "/int_footer_app\r\n", "http://service.mvideo.ru/universal-pay/\r\n", "/credit\r\n", "http://service.mvideo.ru/installation/\r\n", "http://service.mvideo.ru/bistroservice/\r\n", "/exchange\r\n", "/delivery\r\n", "/help\r\n", "/shop-feedbacks/?eshop=true\r\n", "http://www.mvideo.ru/forum/\r\n", "http://market.yandex.ru/shop/211/reviews/add\r\n", "http://facebook.com/mvideo.ru\r\n", "http://twitter.com/mvideo\r\n", "http://vk.com/mvideo\r\n", "http://odnoklassniki.ru/mvideo\r\n", "http://youtube.com/mvideoru\r\n", "/gazeta-mvideo\r\n");
$arLinks = array();
$arLink = array();
$arPropsLinks = array();
$count = 0;
$site_url = "http://www.mvideo.ru";
$html_i = file_get_contents('http://www.mvideo.ru/catalog');
$page = new Pagenation();
if ($html_i) {
    $document_i = phpQuery::newDocument($html_i);
    foreach ($document_i->find('.list-element a') as $key_index => $element_index) {
        $pq = pq($element_index);
        $arLinks['item']['link_catalog'][$key_index] = (($pq->attr('href') != "#") || (in_array($pq->attr('href'), $arExclusion))) ? $pq->attr('href')  . "\r\n" : "";
    }
}
foreach ($arExclusion as $keys => $element) {
    $key = array_search($element, $arLinks['item']['link_catalog']);
    if ($key !== false) {
        unset($arLinks['item']['link_catalog'][$key]);
    }
}
$arUnique = array_unique($arLinks['item']['link_catalog']);
file_put_contents('categories.txt',$arUnique);
foreach ($arUnique as $key_catalog => $link_child) {
    if (!in_array(rtrim($link_child), $arExclusion)) {
        sleep(10);
        if($html = file_get_contents('http://www.mvideo.ru' . rtrim($link_child))) {
            if ($html) {
                $document = phpQuery::newDocument($html);
                $arPropsLinks = $page->recursionSearch($document, ".ico-pagination-next", $site_url);
                file_put_contents('categories_page.txt', $arLink,FILE_APPEND);
                $arLink=array();
            }
        }
    } else {
        break;
    }
}
sleep(10);
echo 'item';
ob_flush();
flush();
//require_once 'item.php';
?>