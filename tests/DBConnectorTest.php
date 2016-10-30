<?php
 
require_once(dirname(__FILE__).'/../classes/DBConnector.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\DBConnector;

class DBConnectorTest extends TestCase
{
  private static $MsSQLCompName = 'WS-MSK-A2422';
  private static $testdbfile = 'testdbconnection.ini';
  private static $badtestdbfile = 'badtestdbconnection.ini';  
  
  public static function setUpBeforeClass()
  {
    self::prepareDBIniFile();
    self::prepareDBIniFile(true);
  }  
  
  public static function tearDownAfterClass()
  {
  	 unlink(dirname(__FILE__).'/'.self::$testdbfile);
  	 unlink(dirname(__FILE__).'/'.self::$badtestdbfile);  	 
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
  * Writes test database connection parameters file
  * @return void
  */
  private static function prepareDBIniFile($wrong = false)
  {
	  $locCompName = getenv("COMPUTERNAME");
	  $iniArray = null;
	  if (strcmp($locCompName,self::$MsSQLCompName)===0)
	  {
		  $iniArray = self::getMSSQLIniArray($wrong);
	  }
	  else
	  {
		  $iniArray = self::getMySQLIniArray($wrong);
	  }
	  $pathdb = ($wrong) ? dirname(__FILE__).'/'.self::$badtestdbfile : dirname(__FILE__).'/'.self::$testdbfile;
	  $iniFile = fopen($pathdb,'w');
	  foreach ($iniArray as $iniString) fwrite($iniFile, $iniString);
	  fclose($iniFile);
  }
  
  /**
  * Prepares array of ms sql database settings
  * @return string[]
  */
  private static function getMSSQLIniArray($wrongSettings = false)
  {
	 $result = array();
  	 $result[] = "DBEngine: mssql;\r\n"; 
  	 $result[] = "DBHost: ws-msk-a2422;\r\n";
	 $result[] = "DBName: naturetrip;\r\n";
	 $result[] = "DBUser: ntrip;\r\n";
	 $result[] = ($wrongSettings) ? "DBPsw: wrongpsw;\r\n" : "DBPsw: 123;\r\n";
  	   
  	 return $result;
  }
  
  /**
  * Prepares array of my sql database settings
  * @return string[]
  */
  private static function getMySQLIniArray($wrongSettings = false)
  {
	 $result = array();
  	 $result[] = "DBEngine: mysql;\r\n"; 
  	 $result[] = "DBHost: 127.0.0.1;\r\n";
	 $result[] = "DBName: naturetrip;\r\n";
	 $result[] = "DBUser: ntrip;\r\n";
	 $result[] = ($wrongSettings) ? "DBPsw: wrongpsw;\r\n" : "DBPsw: 123;\r\n";
  	   
  	 return $result;
  }
}
?>
