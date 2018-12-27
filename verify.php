<?php
$access_token = "eAnt4bRuZ7yYDz0JTDKUhbQp0slqwUHMepuTGOfbhZwJurCrd7y8qXjX8UaST8xQsknAI6CN4nWGv3t6LwkONikxfursy4+Neax1rgBT2g7HmHswuqR4iA7T2zRJUYHyuTWZnN7niYM1dl+0qJCnvQdB04t89/1O/w1cDnyilFU=";

$url = 'https://api.line.me/v2/oauth/verify';

// $headers = array('Content-Type : application/x-www-form-urlencoded');
// $body = array('access_token'. $access_token);

$ch = curl_init($url);

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_HTTPBODAY, $body);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,     $access_token); 
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/x-www-form-urlencoded')); 


$result = curl_exec($ch);
curl_close($ch);

echo $result;
