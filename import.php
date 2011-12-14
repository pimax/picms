<?php
/*
$_link = mysql_connect('localhost', 'root', '');
mysql_select_db('dev_fashiondb', $_link);
mysql_query("SET names utf8", $_link);

$aRes = array();
$res = mysql_query("SELECT * FROM publications_categories", $_link);
while ($row = mysql_fetch_array($res)) {
    $aRes[] = $row['alias'];
}

echo implode("|", $aRes);

mysql_close($_link);*/