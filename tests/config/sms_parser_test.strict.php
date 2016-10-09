<?php

/* 
 * a bunch of fixtures to test SmsParser
 */

return [
    'patterns' => [
        "/^Пароль\W+(\d+)$/" => [false, 'code'],
        "/^Спишется\W+(\d+(?:,\d+))(\w+)\.?$/" => [false, 'amount', 'currency'],
        '/^Перевод на счет\W+(\d+)$/' => [false, 'recipient'],
    ],
];

