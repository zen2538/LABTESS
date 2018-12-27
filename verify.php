<?php
$access_token = "2oky1ZI16oU/jstjZXqdKV9qrh0DrXKDMf/S9EBZgs8HgMM3pz5770YAR624LGu7sknAI6CN4nWGv3t6LwkONikxfursy4+Neax1rgBT2g6t9eoXUuA/xqt0us4C1jV3v22g8LwTAhtntOVUKh3cfgdB04t89/1O/w1cDnyilFU=";

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
