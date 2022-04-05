<?php
include "./inc/functions/blogConnect.php";

header("Content-type:application/json");

$json = array();

$result = $connect_db->getBlog($table);

array_push($json,$result);

echo json_encode($json);

