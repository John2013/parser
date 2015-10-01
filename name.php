<?php
header("Content-Type: text/html; charset=utf-8");
ini_set("max_execution_time","0");
ini_set('memory_limit','-1');
require_once 'config.php';
$site_url = "http://www.mvideo.ru";
require_once 'phpQuery-onefile.php';
$file_array = file("item.txt");
foreach ($file_array as $key_catalog => $link_child) {
    sleep(10);
    $delimiter = ';;';
    $prod_id = explode($delimiter,$link_child);
    $mysqli->query("INSERT INTO  `gutfisher_parser1`.`mvname` (`id_name` , `mvideo_id` , `name` , `cat` , `parsing_date` , `reviews_count` , `price`) VALUES (NULL,  '$prod_id[0]' ,  '$prod_id[1]',  '',  NULL,  '$prod_id[3]',  '$prod_id[2]');");
}
sleep(10);
echo 'comment';
ob_flush();
flush();
//require_once 'comment.php';
?>