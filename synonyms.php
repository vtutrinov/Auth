<?php
mysql_connect('localhost', 'root', '123');
mysql_select_db('ulmart');
mysql_query('SET NAMES utf8;');
$cats = mysql_query('SELECT * FROM hard_price_list_1');
while ($row = mysql_fetch_array($cats)) {
    $sql = "UPDATE PRICE_FOLDERS_NEW
            SET GOOD_CAT_ID=".$row['id']." WHERE DESCR LIKE '%".$row['name']."%'";
    $res = mysql_query($sql);
}
?>
