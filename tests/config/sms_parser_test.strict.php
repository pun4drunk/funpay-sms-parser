<?php

/* 
 * a bunch of fixtures to test SmsParser
 */

return [
    'patterns' => [
      "/^Пароль\W+(\d+)$/ui" => [false, 'code'],
      "/^Спишется\W+(\d+(?:,\d+))([^\d.]+)\.?$/ui" => [false, 'amount', 'currency'],
      '/^Перевод на счет\W+(\d+)$/ui' => [false, 'recipient'],
    ],
];

