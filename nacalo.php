<?
header("Content-Type: text/html; charset=utf-8");
ini_set("max_execution_time", "0");
ini_set('memory_limit', '-1');
ob_start();
require_once 'phpQuery-onefile.php';
echo 'config';
ob_flush();
flush();
require_once 'config.php';
sleep(10);
echo 'categories';
require_once 'categories.php';
?>