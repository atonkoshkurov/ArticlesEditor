<?php
 
require_once(dirname(__FILE__).'/../classes/ArticleManager.php');
require_once(dirname(__FILE__).'/../classes/ArticleDescription.php');
require_once(dirname(__FILE__).'/../classes/DBConnector.php');
require_once(dirname(__FILE__).'/../classes/ArticleManagerException.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\ArticleManager;
use ArticlesEdition\ArticleDescription;
use ArticlesEdition\DBConnector;
use ArticlesEdition\ArticleManagerException;

class ArticleManagerTest extends TestCase
{
  const mysqltestfile = 'testmysqldb.ini';
  const mssqltestfile = 'testmssqldb.ini';  
  const MsSQLCompName = 'WS-MSK-A2422';
  const TABLENAME = 'articles';
    
  private static $testdbconnector = null;
  private static $artManager = null;  
  
  public static function setUpBeforeClass()
  {
    self::setDBConnector();
    self::setInitialStateOfArticles();
    self::createArticleManager();
  }
  
  public static function tearDownAfterClass()
  {
  	 self::setInitialStateOfArticles();
  }  
  
  public function setUp(){ }
  public function tearDown(){ }
 
  public function testNewArticleDate() 
  {
	 $currentDay = date("Y-m-d");	 
	 $artId = self::$artManager->add('test article');
	 $artDescription = self::$artManager->getArticle($artId);
	 $this->assertEquals($artDescription->date,$currentDay);
  }  
  
  public function testAdd()
  {
    $beforeAmount = self::$artManager->getAmount();
    $artId = self::$artManager->add('test article');
    $afterAmount = self::$artManager->getAmount();
    $this->assertEquals($afterAmount,$beforeAmount + 1);
     
    return $artId;
  }
  
  /**
  * @depends testAdd
  */
  public function testEdit($artId)
  {
    $newtitle = 'new test article';
    self::$artManager->edit($artId, $newtitle);
    $artDescription = self::$artManager->getArticle($artId);
    $this->assertEquals($artDescription->title,$newtitle);
  }
  
  /**
  * @depends testAdd
  */
  public function testWrongIdEdit($artId)
  {
  	 $this->setExpectedException('ArticleManagerException');
  	 self::$artManager->remove($artId);
  	 self::$artManager->edit($artId, 'test title');
  }
  
  /**
  * @depends testAdd
  */
  public function testRemove($artId)
  {
    $beforeAmount = self::$artManager->getAmount();
    self::$artManager->remove($artId);
    $afterAmount = self::$artManager->getAmount();
    $this->assertEquals($afterAmount,$beforeAmount - 1);
  }
  
  /**
  * @depends testAdd
  */
  public function testWrongIdRemove($artId)
  {
  	 $this->setExpectedException('ArticleManagerException');
  	 self::$artManager->remove($artId);
  	 self::$artManager->remove($artId);
  }
  
  /**
  * @depends testAdd
  */
  public function testGetWrongArticle($artId)
  {
    $this->setExpectedException('ArticleManagerException');
  	 self::$artManager->remove($artId);
  	 $artDescription = self::$artManager->getArticle($artId);
  }
  
  public function testGetList()
  {
     self::$artManager->add('test article 1');
     self::$artManager->add('test article 2');
     $ArticlesAmount = self::$artManager->getAmount();
     $articles = self::$artManager->getList();
     $this->assertEquals($ArticlesAmount,count($articles));
  }
  
  public function testGetWrongList()
  {
	  $this->setExpectedException('ArticleManagerException');     
     self::$artManager->add('test article 1');
     self::$artManager->add('test article 2');
     $ArticlesAmount = self::$artManager->getAmount();
     $articles = self::$artManager->getList($ArticlesAmount-1,$ArticlesAmount);
  }
  
  public function testGetRangeList()
  {
     self::$artManager->add('test article 1');
     self::$artManager->add('test article 2');
     $ArticlesAmount = self::$artManager->getAmount();
     $articles = self::$artManager->getList(0,$ArticlesAmount-1);
     $this->assertEquals($ArticlesAmount,count($articles));
  }
  
  public function testGetSequenceNumber()
  {
  	  self::$artManager->add('test article 1');
     self::$artManager->add('test article 2');
     $artId = self::$artManager->add('test article 3');
     $seqNumber = self::$artManager->getArticleSequenceNumber($artId);
     $this->assertEquals($seqNumber,3);
  }
  
  public function testGetWrongSequenceNumber()
  {
  	  $this->setExpectedException('ArticleManagerException');
  	  $artId = self::$artManager->getArticleSequenceNumber(1);
  }
  
  private static function createArticleManager()
  {
  	 self::$artManager = new ArticleManager(self::$testdbconnector);
  }  
  
  private static function setDBConnector()
  {
	 $locCompName = getenv("COMPUTERNAME");
	 if (strcmp($locCompName,self::MsSQLCompName)===0)
	 {
	 	self::$testdbconnector = new DBConnector(dirname(__FILE__).'/'.self::mssqltestfile);
	 }
	 else
	 {
		self::$testdbconnector = new DBConnector(dirname(__FILE__).'/'.self::mysqltestfile);
	 }
  }  
  
  private static function setInitialStateOfArticles()
  {
	 $clearTableText = 'DELETE from '.self::TABLENAME.';';
	 $resetAutoincrementText = 'ALTER TABLE '.self::TABLENAME.' auto_increment = 0';
	 $loc_connection = self::$testdbconnector->startConnection();
	 $stmt = $loc_connection->prepare($clearTableText);
	 $stmt->execute();
	 $stmt = $loc_connection->prepare($resetAutoincrementText);
	 $stmt->execute();
	 self::$testdbconnector->closeConnection($loc_connection);
  }
}
?>
