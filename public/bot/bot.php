<?php
require_once("Telegram.php");
// require_once("TelegramErrorLogger.php");
$telegram=new Telegram('2101715389:AAFHNs02NcuyK9TDe-ZkuYcTCSlrHVlqPEY');
$chat_id = $telegram->ChatID();
$content = array('chat_id' => $chat_id, 'text' => 'Test');
$telegram->sendMessage($content);