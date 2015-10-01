<?php
$server = 'gutfisher.ru';
$user = 'gutfisher';
$password = 'CClXyKIG5';

$dblink = mysql_connect($server, $user, $password);
$database = 'gutfisher_parser1';
$selected = mysql_select_db($database, $dblink);
mysql_query('SET NAMES utf8');
?>