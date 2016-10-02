<?php
 
require_once(dirname(__FILE__).'/../classes/PictureError.php');
require_once(dirname(__FILE__).'/../classes/ErrorPage.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\PictureError;
use ArticlesEdition\ErrorPage;

class ErrorPageTest extends TestCase
{
  public function setUp(){ }
  public function tearDown(){ }
 
  public function testErrorText()
  {
      $errortest = $this->getExampleText();
      $pictErrors = $this->getPreparedPictureErrors();      
      $pageText = ErrorPage::showErrors($pictErrors);
      $this->assertEquals($errortest, $pageText);
  }

  /**
	* Generates sample picture errors
	* @return PictureError[]
	*/
  private function getPreparedPictureErrors()
  {
  	   $perror1 = new PictureError();
  	   $perror1->pictureNumber = 1;
  	   $perror1->errorText = 'Размер рисунка №1 превышает допустимые размеры.';
  	   
  	   $perror2 = new PictureError();
  	   $perror2->pictureNumber = 2;
  	   $perror2->errorText = 'Данные рисунка №3 имеют не корректный формат.';
  	   
  	   $result = array();
  	   $result[] = $perror1;
  	   $result[] = $perror2;
  	   
  	   return $result;
  }
  
  /**
	* Gets sample error text for 2 predefined picture errors 
	* @return string 
	*/
  private function getExampleText()
  {
  	   $filename = dirname(__FILE__).'/error_artlist.html';
		$result = readfile($filename);

		return $result;
  }
}
?>
