<?php
 
require_once(dirname(__FILE__).'/../classes/DBConnector.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\DBConnector;

class DBConnectorTest extends TestCase
{
  private static $MsSQLCompName = 'WS-MSK-A2422';
  private static $testdbfile = 'testdbconnection.ini';
  
  public function setUp()
  {
	 $this->prepareDBIniFile();
  }
  
  public function tearDown()
  {
	 unlink(dirname(__FILE__).'/'.self::$testdbfile);
  }
 
  /**
  * @covers DBConnector::decomposeParameter
  */
  public function testParameterDecomposition()
  {
      $paramString = 'DBHost: 127.0.0.1;';
	  $method = new ReflectionMethod('ArticlesEdition\DBConnector', 'decomposeParameter');
	  $method->setAccessible(TRUE);
	  $params = $method->invoke(new DBConnector(dirname(__FILE__).'/'.self::$testdbfile),$paramString);
	        	  	  
	  $this->assertEquals('DBHost',$params["name"]);
	  $this->assertEquals('127.0.0.1',$params["value"]);
  }
  
  /**
  * @covers DBConnector::decomposeParameter
  */
  public function testWrongParameterDecomposition()
  {
      $paramString = 'DBHost; 127.0.0.1:';
  }
  
  public function testCorrectDBConnection()
  {
	  
  }
  
  public function testWrongDBConnection()
  {
	  
  }
  
  /**
  * Writes test database connection parameters file
  * @return void
  */
  private function prepareDBIniFile()
  {
	  $locCompName = getenv("COMPUTERNAME");
	  $iniArray = null;
	  if (strcmp($locCompName,self::$MsSQLCompName)===0)
	  {
		  $iniArray = $this->getMSSQLIniArray();
	  }
	  else
	  {
		  $iniArray = $this->getMySQLIniArray();
	  }
	  $iniFile = fopen(dirname(__FILE__).'/'.self::$testdbfile,'w');
	  foreach ($iniArray as $iniString) fwrite($iniFile, $iniString);
	  fclose($iniFile);
  }
  
  /**
  * Prepares array of ms sql database settings
  * @return string[]
  */
  private function getMSSQLIniArray()
  {
	 $result = array();
  	 $result[] = "DBEngine: mssql;\r\n"; 
  	 $result[] = "DBHost: ws-msk-a2422;\r\n";
	 $result[] = "DBName: naturetrip;\r\n";
	 $result[] = "DBUser: ntrip;\r\n";
	 $result[] = "DBPsw: 123;\r\n";
  	   
  	 return $result;
  }
  
  /**
  * Prepares array of my sql database settings
  * @return string[]
  */
  private function getMySQLIniArray()
  {
	 $result = array();
  	 $result[] = "DBEngine: mysql;\r\n"; 
  	 $result[] = "DBHost: 127.0.0.1;\r\n";
	 $result[] = "DBName: naturetrip;\r\n";
	 $result[] = "DBUser: ntrip;\r\n";
	 $result[] = "DBPsw: 123;\r\n";
  	   
  	 return $result;
  }
}
?>
