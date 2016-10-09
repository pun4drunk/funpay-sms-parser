FunPay SMS Parser
===============================

OVERVIEW
-------------------
This parser is made as a part of test task for FunPay.

It allows you to parse messages generated by [FunPay Yandex Emulator] (http://funpay.ru/yandex/emulator).

INSTALLATION
-------------------
Clone package: 
```
git clone https://github.com/pun4drunk/funpay-sms-parser
```

Install composer dependencies
```
composer install
```

Optional: Run tests to ensure Parser is compatible with your environment
```
composer test
```

USAGE
-------------------

Parser should be constructed with configuration array
Default configuration is as follows:
```
[
  //new line delimiter, NULL will be converted into PHP_EOL value
  'eol' => NULL,
  // field patterns in preg_match pattern=>matches format
  'patterns' => [
      "/^Пароль\W+(\w+)$/ui" => [false, 'code'],
      "/^Спишется\W+(\d+(?:,\d+)?)\s*([^\d.]+)\.?$/ui" => [false, 'amount', 'currency'],
      '/^Перевод\s+на\s+счет\W+(\w+)$/ui' => [false, 'recipient'],
  ],
];
```

Provided configuration is flexible enough to support string-based values for both ```code``` and ```recipient``` properties
To use strict configuration, you can pass for example, like this:

```
[
  'patterns' => [
    "/^Пароль\W+(\d+)$/ui" => [false, 'code'],
    "/^Спишется\W+(\d+(?:,\d+)?)\s*([^\d.]+)\.?$/ui" => [false, 'amount', 'currency'],
    '/^Перевод на счет\W+(\d+)$/ui' => [false, 'recipient'],
  ],
];
```

This will restrict both ```code``` and ```recipient``` to be integers.

Adjusting configuration is the way to overwrite any rules for the parser.

To parse a string, you should pass it in utf8-encoding into Parser::parse method, as follows:

```
  $parser = new FunPay\SmsParser\SmsParser($config);
  $result = $parser->parse(<<<EOT
Пароль: 4102
Спишется 100,51р.
Перевод на счет 41001174928714
EOT);
```

Result will be something like
```
[
  'code' => "4102",
  'amount' => "100,51",
  'currency' => 'р',
  'recipient' => '41001174928714',
]
```