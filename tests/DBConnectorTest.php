<?php
 
require_once(dirname(__FILE__).'/../classes/DBConnector.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\DBConnector;

class DBConnectorTest extends TestCase
{
  const mysqltestfile = 'testmysqldb.ini';
  const mysqlbadtestfile = 'badtestmysqldb.ini';
  const mssqltestfile = 'testmssqldb.ini';
  const mssqlbadtestfile = 'badtestmssqldb.ini';  
  
  const MsSQLCompName = 'WS-MSK-A2422';
  
  private static $testdbfile = '';
  private static $badtestdbfile = '';  
  
  public static function setUpBeforeClass()
  {
    self::prepareDBIniFile();
  }  
  
  public static function tearDownAfterClass()
  {
  	   	 
  }
  
  public function setUp()
  {
	 
  }
  
  public function tearDown()
  {
	  
  }
 
  /**
  * @covers DBConnector::decomposeParameter
  */
  public function testParameterDecomposition()
  {
     $params = $this->getDecomposedParams('DBHost: 127.0.0.1;');
	        	  	  
	  $this->assertEquals('DBHost',$params["name"]);
	  $this->assertEquals('127.0.0.1',$params["value"]);
  }
  
  /**
  * @covers DBConnector::decomposeParameter
  */
  public function testWrongParameterDecomposition()
  {
     $params = $this->getDecomposedParams('DBHost; 127.0.0.1:');
      
     $this->assertEquals('',$params["name"]);
	  $this->assertEquals('',$params["value"]);
  }
  
  public function testCorrectDBConnection()
  {
	  $dbconn = new DBConnector(dirname(__FILE__).'/'.self::$testdbfile);
	  $loc_connection = $dbconn->startConnection();
	  $this->assertTrue(true); 
	  $dbconn->closeConnection($loc_connection);
  }
  
  public function testWrongDBConnection()
  {
	  $this->setExpectedException('PDOException');	  
	  $dbconn = new DBConnector(dirname(__FILE__).'/'.self::$badtestdbfile);
	  $loc_connection = $dbconn->startConnection();	  
  }
  
  private function getDecomposedParams($paramString)
  {
  	  $method = new ReflectionMethod('ArticlesEdition\DBConnector', 'decomposeParameter');
	  $method->setAccessible(TRUE);
	  $params = $method->invoke(new DBConnector(dirname(__FILE__).'/'.self::$testdbfile),$paramString);
	  return $params;
  }
  
  /**
  * Chooses test database connection parameters file
  * @return void
  */
  private static function prepareDBIniFile()
  {
	  $locCompName = getenv("COMPUTERNAME");
	  if (strcmp($locCompName,self::MsSQLCompName)===0)
	  {
		  self::$badtestdbfile = self::mssqlbadtestfile;
		  self::$testdbfile = self::mssqltestfile;
	  }
	  else
	  {
		  self::$badtestdbfile = self::mysqlbadtestfile;
		  self::$testdbfile = self::mysqltestfile;
	  }
  }
}
?>
