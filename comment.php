<?php
require_once 'phpQuery-onefile.php';
$arExclusion = array("/news-landing\r\n", "/nam-nevseravno\r\n", "/company\r\n", "http://invest.mvideo.ru\r\n", "http://job.mvideo.ru\r\n", "/eco\r\n", "/fund\r\n", "/rent\r\n", "/contacts\r\n", "/how-to-buy\r\n", "/pamyatka\r\n", "/pickup\r\n", "/catalog\r\n", "/deliverypage\r\n", "http://www.mvideo-bonus.ru\r\n", "/int_footer_app\r\n", "http://service.mvideo.ru/universal-pay/\r\n", "/credit\r\n", "http://service.mvideo.ru/installation/\r\n", "http://service.mvideo.ru/bistroservice/\r\n", "/exchange\r\n", "/delivery\r\n", "/help\r\n", "/shop-feedbacks/?eshop=true\r\n", "http://www.mvideo.ru/forum/\r\n", "http://market.yandex.ru/shop/211/reviews/add\r\n", "http://facebook.com/mvideo.ru\r\n", "http://twitter.com/mvideo\r\n", "http://vk.com/mvideo\r\n", "http://odnoklassniki.ru/mvideo\r\n", "http://youtube.com/mvideoru\r\n", "/gazeta-mvideo\r\n");
$arLinks = array();
$arItemLink = array();
$arPropsLinks = array();
$arId = array();
$arComment = array();
$arDate = array();
$arAuth = array();
$arStar = array();
$arLike = array();
$arDislike = array();
$prod_id = ARRAY();//
$count_pass = 0;
$all_count_pass = 0;
$q = 1;
$file_array = file("item.txt");
foreach ($file_array as $key_catalog => $link_child) {
    $delimiter = ';;';
    sleep(1);
    $prod_id = explode($delimiter, $link_child);
    $html = file_get_contents('http://www.mvideo.ru/sitebuilder/blocks/browse/product-detail/tabs/product-reviews.jsp?productId=' . $prod_id[0] . '&sortBy=-published&page=' . $q);
    $document = phpQuery::newDocument($html);
    $numcomm = 0;
    $arId[] = $prod_id[0];
    foreach ($document->find('.pagination-item') as $key_index => $element_index) {
        $pq = pq($element_index);
        $numcomm = ($pq->text());
    }
    if ($numcomm == 0) {
        $numcomm = 1;
    };
    for ($q = 1; $q <= $numcomm; $q++) {
        sleep(1);
        $html = file_get_contents('http://www.mvideo.ru/sitebuilder/blocks/browse/product-detail/tabs/product-reviews.jsp?productId=' . $prod_id[0] . '&sortBy=-published&page=' . $q);
        $document = phpQuery::newDocument($html);
        foreach ($document->find('.product-review-date') as $key_index => $element_index) {
            $pq = pq($element_index);
            $arItemLink['item']['date'][$prod_id[0]][$q][$key_index] = ($pq->text());
            array_push($arDate, array("ID" => $prod_id[0],
                "DATE" => $arItemLink['item']['date'][$prod_id[0]][$q][$key_index]));
        }
        foreach ($document->find('.product-review-content p') as $key_index => $element_index) {
            sleep(2);
            $pq = pq($element_index);
            $arItemLink['item']['comment'][$prod_id[0]][$q][$key_index] = ($pq->text());
            array_push($arComment, array("ID" => $prod_id[0],
                "COMMENT" => $arItemLink['item']['comment'][$prod_id[0]][$q][$key_index]));
        }
        foreach ($document->find('.product-review-author-name') as $key_index => $element_index) {
            sleep(3);
            $pq = pq($element_index);
            $lol=($pq->text());
            $zap= preg_replace('{[,]}','', $lol);
            $arItemLink['item']['an'][$prod_id[0]][$q][$key_index] = $zap;
            array_push($arAuth, array("ID" => $prod_id[0],
                "AUTHOR" => $arItemLink['item']['an'][$prod_id[0]][$q][$key_index]));
        }
$i=0;
        foreach ($document->find('.product-review') as $key_index => $element_index) {
            sleep(4);
            $pq = pq($element_index);
            $arItemLink['item']['pr'][$prod_id[0]][$q][$key_index] = $pq->find('i.font-icon.icon-star.active')->length;
            $arItemLink['item']['lik'][$prod_id[0]][$q][$key_index] = pq(pq(pq('.product-review')->find('span.btn-like-text'))->get($i))->text();
            $arItemLink['item']['dlik'][$prod_id[0]][$q][$key_index] = pq(pq(pq('.product-review')->find('span.btn-like-text'))->get($i+1))->text();
            $i=$i+2;
            array_push($arStar, array("ID" => $prod_id[0],
                "STAR" => $arItemLink['item']['pr'][$prod_id[0]][$q][$key_index]));
            array_push($arLike, array("ID" => $prod_id[0],
                "LIKE" => $arItemLink['item']['lik'][$prod_id[0]][$q][$key_index]));
            array_push($arDislike, array("ID" => $prod_id[0],
                "DISLIKE" => $arItemLink['item']['dlik'][$prod_id[0]][$q][$key_index]));
        }
        $count_pass++;
        $all_count_pass++;
        if ($count_pass == 10) {
            $str = "";
            foreach ($arComment as $key => $element) {
                $str .= "(NULL, '{$arComment[$key]["ID"]}', '{$arDate[$key]["DATE"]}', '{$arComment[$key]["COMMENT"]}', '{$arAuth[$key]["AUTHOR"]}','{$arStar[$key]["STAR"]}','{$arLike[$key]["LIKE"]}','{$arDislike[$key]["DISLIKE"]}',NULL),";
            }
            $str = substr($str, 0, -1);
            $str .= ";";
            mysql_query("INSERT INTO `gutfisher_parser1`.`comment_test` (`id_comment`, `id_tovara`, `date_comment`, `text_comment`, `AUTHOR`, `STAR`, `LIKE`, `DISLIKE`, `unnamed`) VALUES {$str}");
            $count_pass = 0;
        }
    }
}
if ($all_count_pass < 10) {
    $str = "";
    foreach ($arComment as $key => $element) {
        $str .= "(NULL, '{$arComment[$key]["ID"]}', '{$arDate[$key]["DATE"]}', '{$arComment[$key]["COMMENT"]}', '{$arAuth[$key]["AUTHOR"]}','{$arStar[$key]["STAR"]}','{$arLike[$key]["LIKE"]}','{$arDislike[$key]["DISLIKE"]}',NULL),";
    }
    $str = substr($str, 0, -1);
    $str .= ";";
    mysql_query("INSERT INTO `gutfisher_parser1`.`comment_test` (`id_comment`, `id_tovara`, `date_comment`, `text_comment`, `AUTHOR`, `STAR`, `LIKE`, `DISLIKE`, `unnamed`) VALUES {$str}");
}
echo 'zbs';
ob_flush();
flush();
ob_end_flush();
?>