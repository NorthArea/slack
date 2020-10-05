<?php

if (PHP_SAPI !== 'cli') {
    exit(1);
}

// nginx error log example: /home/td/log/error.log
$source = '';

// temp error log example: /home/td/log/error_tmp.log
$dest = __DIR__ . '/../temp.log';

// example hook: https://hooks.slack.com/services/***/****/****
// more details: https://api.slack.com/messaging/webhooks
$hook = '';

// slack channel example: #channel
$channel = "";

exec('comm -13 ' . $dest . ' ' . $source . '  2>&1', $output);

if ( ! $output)
    exit();

$result = "";
// Filter
foreach ($output as $val) {
    if (str_ireplace([
            'is not in sorted order',
        ], '', $val) == $val)
        $result .= $val . "\n";
}

if ($result)
{
    $data = json_encode([
        'channel' => $channel,
        'text' => "```" . $result . " ```",
        'icon_emoji' =>  ':bug:',
        'username' => 'bug'
    ]);
    $ch = curl_init($hook);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['payload' => $data]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

copy($source, $dest);
