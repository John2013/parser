<?php
$server = 'gutfisher.ru';
$user = 'gutfisher';
$password = 'CClXyKIG5';
$database = 'gutfisher_parser1';
$mysqli = new mysqli($server, $user, $password, $database);
//$dblink = mysqli_connect($server, $user, $password);
//$selected = mysql_select_db($database, $dblink);
$mysqli->query('SET NAMES utf8');
?>