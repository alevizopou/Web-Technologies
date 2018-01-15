<?php
$search_word=$_GET['q'];
$sql = mysql_query("SELECT * FROM orders WHERE price LIKE '$price'");
$record_count=mysql_num_rows($sql);
//Display count.........
echo $record_count;
?>