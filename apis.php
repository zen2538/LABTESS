<?php
$access_token = "eAnt4bRuZ7yYDz0JTDKUhbQp0slqwUHMepuTGOfbhZwJurCrd7y8qXjX8UaST8xQsknAI6CN4nWGv3t6LwkONikxfursy4+Neax1rgBT2g7HmHswuqR4iA7T2zRJUYHyuTWZnN7niYM1dl+0qJCnvQdB04t89/1O/w1cDnyilFU=";

$userId ='U09daf41b2443adfdfcbdfc3b3858f3eb';

$content = file_get_contents('php://input');//  Call LINE
$events = json_decode($content, true); // Call LINE
//$database = file_get_contents('http://35.198.193.206/jsonline.php'); // Call DataBase
//$datas = json_decode($database, true);  // Call DataBase


function CallLineGetName($access_token,$userId){

  $url = 'https://api.line.me/v2/bot/profile/'.$userId;
  $headers = array('Authorization: Bearer ' .$access_token);
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

$result = CallLineGetName($access_token,$userId);
$json = json_decode($result,TRUE); // CallLineGetName();

if(!is_null($json['displayName'])){

  foreach ($json as $type => $value){
     if($type == 'displayName'){
        $name = $value; // send reply text name
     }
  }
}
// Call DataBase
if (!is_null($datas['id'])) {
    foreach ($datas as $type => $value) {
        
        if($type == 'id'){
          $id = $value;
        }elseif($type == 'humidity'){
          $humidity = $value;
        }elseif($type == 'tempC') {
          $tempC = $value;
        }elseif($type == 'tempF') {
          $tempF = $value;          
        }elseif($type == 'heatIndexC') {
          $heatIndexC = $value;         
        }elseif($type == 'heatIndexF') {
          $heatIndexF = $value;        
        }elseif($type == 'datetime') {
          $datetime = $value;       
        }   
    } 
}

// Call events line
if (!is_null($events['events'])) {
  foreach ($events['events'] as $event) {
    if ($event['type'] == 'message' && $event['message']['type'] == 'text'){
        $text = $event['message']['text'];

        if ($text == "สวัสดี" or $text == "สวัสดีครับ" or $text == "open" or $text == "hi"){
          $text = $text." คุณ ".$name."\n สามารถเลือกเมนูได้เลยครับ ";
        }elseif($text == "1"){
          $text = "ความชื้นตอนนี้จะอยู่ที่ ".$humidity." ครับ";
        }elseif ($text == "2"){
          $text = "อุณหภูมิ ตอนนี้จะอยู่ที่ ".$tempC." (°C) ครับ";
        }elseif ($text == "3"){
          $text = "ค่าเฉลี่ยองศาจะอยู่ที่ ".$heatIndexC." (°C) ครับ";
        }elseif ($text == "4"){
          $text = "ค่าเฉลี่ยฟาเรนไฮต์จะอยู่ที่ ".$heatIndexF." (°F) ครับ";
        }elseif ($text == "5"){
          $text = "วันเวลา :".$datetime;
        }else if($text == "6"){
          $text = "อุณหภูมิ ตอนนี้จะอยู่ที่ ".$tempC." (°C) ครับ และ ".$tempF." (°F) ครับ\n - ค่าเฉลี่ยจะอยู่ที่ ".$heatIndexC." (°C) ครับ และ ".$heatIndexF." (°F) ครับ\n อับเดจล่าสุดเมื่อวันที่ ".$datetime." ครับ";
        }else if($text == "ใครสร้าง Mark I"){
          $text ="Mark I ถูกสร้างโดย mr.mach ครับ";
        }else{
          $text = "ขอเวลาเรียนรู้ก่อนนะครับ";
        }

        $replyToken = $event['replyToken'];
        $messages = [
          'type' => 'text',
          'text' => $text
      ];
    }elseif ($event['type'] == 'message' && $event['message']['type'] == 'sticker'){
        $id = $event['message']['id'];
        $stickerId = $event['message']['stickerId'];
        $packageId = $event['message']['packageId'];

        $replyToken = $event['replyToken'];
        $messages = [
          'type' => 'sticker',
          'id' => $id,
          'stickerId' => $stickerId,
          'packageId' => $packageId      
        ];
    
    }
    // Make a POST Request to Messaging API to reply to sender
    $url = 'https://api.line.me/v2/bot/message/reply';
    $data = [
      'replyToken' => $replyToken,
      'messages' => [$messages],
    ];
    $post = json_encode($data);
    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    echo $result . "\r\n";
  }
}
echo "sucess full";

