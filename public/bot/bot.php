<?php
include ("Telegram.php");
$telegram=new Telegram("2101715389:AAFHNs02NcuyK9TDe-ZkuYcTCSlrHVlqPEY");
$result = $telegram->getData();
$text = $result['message'] ['text'];
$chat_id = $result['message'] ['chat']['id'];
$content = array('chat_id' => $chat_id, 'text' => $text);
$telegram->sendMessage($content);