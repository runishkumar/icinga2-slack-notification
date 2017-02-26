#!/usr/bin/env php

<?php
// Slack incoming webhooks url
//define('SLACK_WEBHOOK_URL', 'https://hooks.slack.com/services/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');
define('SLACK_WEBHOOK_URL', 'https://hooks.slack.com/services/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');

try {
    // u => username
    // s => status
    // m => message
    // c => channel
    $requiredArgs = 'u:m:c:s:';
    $arguments = getopt($requiredArgs);

    if (!isset($arguments['m'])) {
        throw new Exception("Did not received message to post to slack.");
    }

    $icon = ':exclamation:';

    switch ($arguments['s']) {
        case 'UP':
        case 'OK':
            $icon = ':tada:';
            break;
        case 'DOWN':
        case 'WARNING':
        case 'CRITICAL':
            $icon = ':warning:';
            break;
    }

    $payload = [
      "channel" => $arguments['c'],
      "username" => $arguments['u'],
      "text" => sprintf("%s %s", $arguments['m'], $icon),
      //"icon_emoji" => ':ghost:'
    ];

    $payloadStr = sprintf("payload=%s", json_encode($payload));

    $curl = sprintf("curl -X POST --data-urlencode %s %s", escapeshellarg($payloadStr), SLACK_WEBHOOK_URL);

    @exec($curl);
} catch (Exception $e) {
    @file_put_contents('/var/log/icinga-slack-notification-error.log', sprintf("%s\n", $e->getMessage()), FILE_APPEND);
}
