<?php

/* 
 * a bunch of fixtures to test SmsParser
 */

return [
    'patterns' => [
      "/^Пароль\W+(\d+)$/ui" => [false, 'code'],
      "/^Спишется\W+(\d+(?:,\d+)?)\s*([^\d.]+)\.?$/ui" => [false, 'amount', 'currency'],
      '/^Перевод\s+на\s+счет\W+(\d+)$/ui' => [false, 'recipient'],
    ],
];

