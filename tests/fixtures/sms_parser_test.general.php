<?php

/* 
 * a bunch of fixtures to test SmsParser
 */

return [
    'main' => [
        'string' => <<<EOT
Пароль: 4102
Спишется 100,51р.
Перевод на счет 41001174928714        
EOT
,
        'result' => [
            'code' => "4102",
            'amount' => "100,51",
            'currency' => 'р',
            'recipient' => '41001174928714',
        ],
    ],
    'shuffled' => [
        'string' => <<<EOT
Спишется 100,51р.
Перевод на счет 41001174928714        
Пароль: 4102
EOT
,
        'result' => [
            'code' => "4102",
            'amount' => "100,51",
            'currency' => 'р',
            'recipient' => '41001174928714',
        ],
    ],
    'formatted1' => [
        'string' => <<<EOT
Спишется: 100,51р.
Перевод на счет: 41001174928714        
Пароль 4102
EOT
,
        'result' => [
            'code' => "4102",
            'amount' => "100,51",
            'currency' => 'р',
            'recipient' => '41001174928714',
        ],
    ],
    'formatted2' => [
        'string' => <<<EOT
Спишется - 100,51р.
Перевод на счет - 41001174928714        
Пароль - 4102
EOT
,
        'result' => [
            'code' => "4102",
            'amount' => "100,51",
            'currency' => 'р',
            'recipient' => '41001174928714',
        ],
    ],
    'case-shuffled' => [
        'string' => <<<EOT
спишется - 100,51р.
перевод на Счет - 41001174928714        
пароль - 4102
EOT
,
        'result' => [
            'code' => "4102",
            'amount' => "100,51",
            'currency' => 'р',
            'recipient' => '41001174928714',
        ],
    ],

];