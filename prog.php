<?php

 
date_default_timezone_set('Asia/Tokyo');
$week = [
  '日', //0
  '月', //1
  '火', //2
  '水', //3
  '木', //4
  '金', //5
  '土', //6
];
$time = date('i');
$time2= date('w');
$weekday=$week[$time2];
require_once __DIR__ . '/vendor/autoload.php';
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);



$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}
foreach ($events as $event) {

if ($event instanceof \LINE\LINEBot\Event\JoinEvent) {
    
$message = "連絡用LineBotです";
  $bot->replyMessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message))
      
  );


    
    continue;
  }





  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }



  $mes=($event->getText());
  
 #$profile = $bot->getProfile($event->getUserId())->getJSONDecodedBody();
  #$message = $profile["displayName"] . "さん、おはようございます！今日も頑張りましょう！";
  #$message2 = "今は".$time."今日の天気は雨です。傘を持っていきましょう！";

if ($mes=="シフト情報"){
  $message4 ="シフト→"."https://docs.google.com/";
$bot->replymessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message4))
);



}



  if ($mes=="業務終了"){
 $message = $weekday."曜日の"."業務お疲れ様でした。";
 $message2 ="業務→"."https://docs.google.com/";
 $message3 = "〜の方→"."https://www.facebook.com/";

  $bot->replymessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message))
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message2))
       ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message3))
  );
}
}
 ?>