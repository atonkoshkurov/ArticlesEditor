<?php
 
//require_once('RemoteConnect.php');
 
class InitialTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }
 
  public function testPHPUnit()
  {
    // �������� ���������� ���������� � ��������
    $arr = ["first" => 1, "second" => 2];
    $this->assertTrue(count($arr) == 2);
  }
}
?>