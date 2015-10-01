<?php
require_once 'phpQuery-onefile.php';
$file_array = file("item.txt");
foreach ($file_array as $key_catalog => $link_child) {
    sleep(10);
    $delimiter = ';;';
    $prod_id = explode($delimiter, $link_child);
    mysql_query("INSERT INTO  `gutfisher_parser1`.`mvname` (`id_name` , `mvideo_id` , `name` , `cat` , `parsing_date` , `reviews_count` , `price`)
VALUES (NULL, '" . $prod_id[0] . "',  '" . $prod_id[1] . "',  '',  NULL,  '" . $prod_id[3] . "',  '" . $prod_id[2] . "');");
}
sleep(10);
echo 'comment';
ob_flush();
flush();
require_once 'comment.php';
?>