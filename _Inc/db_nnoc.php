<?php

//$auth = file("db_gifnoc.php") or exit("plz., check DB config.");
$auth = file($_SERVER["DOCUMENT_ROOT"]."/Hongik_/_Inc/db_gifnoc.php") or exit("plz., check DB config.");

for($i=1;$i<=4;$i++) $auth[$i]=trim(str_replace("\n","",$auth[$i]));

$connect = mysql_connect ($auth[1], $auth[2], $auth[3]);
mysql_select_db ($auth[4], $connect);

?>