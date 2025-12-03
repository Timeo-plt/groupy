<?php
use PHPUnit\Framework\TestCase;
class testTest extends TestCase
{
    public function testExample()
    {
        $result = 2+2;
    
        $this->assertEquals(4, $result);


    }

    public function testAnotherExample()
    {
        $string = "Hello, World!";
    
        $this->assertStringContainsString("World", $string);
    } 
}
?>