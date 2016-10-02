<?php
 
//require_once('RemoteConnect.php');
use PHPUnit\Framework\TestCase; 

class InitialTest extends TestCase
{
  public function setUp(){ }
  public function tearDown(){ }
 
  public function testPHPUnit()
  {
    $arr = ["first" => 1, "second" => 2];
    $this->assertTrue(count($arr) == 2);
  }
}
?>
