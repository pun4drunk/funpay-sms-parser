<?php

namespace FunPay\SmsParser;
/**
 * Helper class to parse transactions SMS messages
 *
 * input example:
 * Пароль: 4102
 * Спишется 100,51р.
 * Перевод на счет 41001174928714
 * 
 * @author vladislavs
 */

class SmsParser {
    
    /**
     * Fields used
     * @var array 
     */
    protected $fields = [
        'code' => NULL, 
        'amount' => NULL,
        'currency' => NULL,
        'recipient' => NULL,
    ];
    
    protected $config = [
        'patterns' => [
            "/^Пароль\W+(\w+)$/" => [false, 'code'],
            "/^Спишется\W+(\d+(?:,\d+))(р)\.?$/" => [false, 'amount', 'currency'],
            '/^Перевод на счет\W+(\w+)$/' => [false, 'recipient'],
        ],
    ];
    
    public function __construct(array $config = []) {
        //populate configuration property with provided overwrites
        $this->config = array_replace_recursive($this->config, array_intersect_key($config, $this->config));
    }
    
    /**
     * Parse input string using configuration property
     * @param type $input
     * @return type
     */
    public function parse($string) {
        
        $result = $this->fields;
        $lines = array_map('trim', explode(PHP_EOL, $string));
        
        foreach ($this->config['patterns'] as $pattern => $fields) {
            
            $count = count($lines);
            for ($i = 0; $i < $count; $i++) {
                if (preg_match($pattern, $lines[$i], $matches)) {
                    $fields = array_filter($fields);
                    $result = array_merge($result, array_combine($fields, array_intersect_key($matches, $fields)));
                    array_splice($lines, $i, 1);
                    break;
                }
            }
        }
        
        return array_intersect_key($result, $this->fields);
    }
    
    
    
}
