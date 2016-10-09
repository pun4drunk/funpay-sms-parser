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
 * output example:
 * [
 *  'code' => "4102",
 *  'amount' => "100,51",
 *  'currency' => 'р',
 *  'recipient' => '41001174928714',
 * ]
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
            "/^пароль\W+(\w+)$/" => [false, 'code'],
            "/^спишется\W+(\d+(?:,\d+))(\w+)\.?$/" => [false, 'amount', 'currency'],
            '/^перевод на счет\W+(\w+)$/' => [false, 'recipient'],
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
        $lines = array_map(function($value) {
            //prepare subject for case-insensitive search
            return mb_strtolower(trim($value));
        }, explode(PHP_EOL, $string));
        
        foreach ($this->config['patterns'] as $pattern => $fields) {
            
            $count = count($lines);
            for ($i = 0; $i < $count; $i++) {
                // go through input lines until we have a pattern match
                if (preg_match($pattern, $lines[$i], $matches)) {
                    $fields = array_filter($fields);
                    // populate result fields with matches
                    $result = array_merge($result, array_combine($fields, array_intersect_key($matches, $fields)));
                    // unset processed line
                    array_splice($lines, $i, 1);
                    break;
                }
            }
        }
        
        // filter result and return
        return array_intersect_key($result, $this->fields);
    }
    
    
    
}
