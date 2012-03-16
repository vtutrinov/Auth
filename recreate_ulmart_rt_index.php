<?php
$link = mysql_connect('127.0.0.1:3306', 'root', '123');
mysql_query("SET NAMES utf8", $link);
mysql_query("SET CHARACTER SET utf8", $link);
mysql_select_db('ulmart', $link);
?>
