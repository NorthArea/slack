<?php
/*
 * Бот для слака ДоброБот
 * Отправляет за предыдущий день статистику по сборам
 */

if (PHP_SAPI !== 'cli') {
    exit(1);
}

// slack channel example: #channel
$channel = "";

// example hook: https://hooks.slack.com/services/***/****/****
// more details: https://api.slack.com/messaging/webhooks
$hook = '';


// Data from database
$total = ["string #1", "string #2"];

$string = '';
foreach ($total as $value) {
    $string .= $value . "\n";
}

$data = json_encode([
    'channel' => $channel,
    'text' => "```" . $string . " ```",
    'icon_emoji' => ':nerd_face:',
    'username' => 'dobrobot'
]);
$ch = curl_init($hook);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, ['payload' => $data]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);