<?php

/**
 * A simple SmsParser test
 *
 * @author vladislavs
 * 
 */
class SmsParserTest extends PHPUnit_Framework_TestCase {
    
    /**
     * CONFIGURATION EXAMPLES: can be extended or deprecated
     */
    const GENERAL = 'general';
    const STRICT = 'strict';
    
    public function testSmsParserGeneral() {
        return $this->doTestSmsParser(static::GENERAL);
    }
    
    public function testSmsParserStrict() {
        return $this->doTestSmsParser(static::STRICT);
    }
    
    protected function doTestSmsParser($type) {
        
        $config = $this->getConfig($type);
        
        foreach ($this->getFixtures($type) as $case => $fixture) {
            
            $parser = new FunPay\SmsParser\SmsParser($config);
            $string = $fixture['string'];
            $expected = $fixture['result'];
            $actual = $parser->parse($string);
            $this->assertEquals($expected, $actual, "$case assertion failed");
            
        }
        
    }
    
    /**
     * Get test fixtures
     * @param type $type
     * @return type
     */
    protected function getFixtures($type) {
        return $this->getResource($type, 'fixtures');
    }
    
    /**
     * Get parser config
     * @param type $type
     * @return type
     */
    protected function getConfig($type) {
        return $this->getResource($type, 'config');
    }
    
    
    /**
     * Get resources from php file
     * @return array
     * @throws Exception
     */
    protected function getResource($type, $resourceName) {
        
        $result = [];
        
        try {
            
            $result = require (getenv("$type.$resourceName.filename"));
            
            if (!is_array($result)) {
                throw new Exception("Invalid fixtures: please ensure $resourceName file is PHP returning array of $resourceName");
            }
            
        } catch (Exception $e) {
            throw new Exception("Failed to load test $resourceName: ". $e->getMessage());
        }
        
        return $result;
    }
}
