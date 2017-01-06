<?php
 
require_once(dirname(__FILE__).'/../classes/ArticleViewer.php');
require_once(dirname(__FILE__).'/../classes/ArticleDescription.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\ArticleViewer;
use ArticlesEdition\ArticleDescription;

class ArticleViewerTest extends TestCase
{
  /**
  * @var int $pageVolume article's amount on a page
  */
  private static $pageVolume = 5;
  
  /**
  * @var string $testDataFile file with test parameters
  */
  private static $testDataFile = 'ArticleViewerSamples.txt';
  
  protected function setUp() {}
  
  protected function tearDown(){ }
 
  /**
  * Gets list of Article descriptions
  * @param xml string with articles description params
  * @return ArticleDescription[] 
  */
  private function prepareArticlesDescr($sourceText)
  {
	$artDescriptions = new SimpleXMLElement($sourceText);
	
	$result = array();
	foreach ($artDescriptions->articleDescription as $artDescription)
	{
		$articleDescr = new ArticleDescription();
		$articleDescr->id = (int) $artDescription->id;
		$articleDescr->date = (string) $artDescription->date;
		$articleDescr->title = (string) $artDescription->title;
		$result[] = $articleDescr;
	}
	
	return $result;
  }
  
  /**
  * Gets a string without '\r\n' at the start and the end of it
  * @param string initial text 
  * @return string 
  */
  private function removeNextRows($beforeStr)
  {
	 $resString = $beforeStr;
	 $nextRowSymb = "\r\n";
	 $firstSymb = substr($resString,0,2);
	 if ($firstSymb == $nextRowSymb)
	 {
		 $resString = substr($resString,2);
	 }
	 $length = strlen($resString);
	 $lastSymb = substr($resString, $length-2);
	 if ($lastSymb == $nextRowSymb)
	 {
		 $resString = substr($resString, 0, $length-2);
	 }
			
	 return $resString;
  }
 
  /**
  * @dataProvider getTableParams
  */
  public function testShowTable($artList, $sampleTableText)
  {
	 $prepSampleTableText = str_replace("\n", "",$sampleTableText); 
     $tableText = ArticleViewer::ShowTable($artList ,self::$pageVolume);
	 $this->assertEquals($tableText,$prepSampleTableText); 
  }

  public function getTableParams() 
  {
  	$result = array();

	$artSamples = file_get_contents(dirname(__FILE__).'/'.self::$testDataFile);
	$startPiece = "//*Начало блока*//";
	$separPiece = "//*Разделитель*//";
	$endPiece = "//*Конец блока*//";
	
	$fromPos = 0;
	$isStart = stripos($artSamples, $startPiece);	
	while ($isStart!==false)
	{
		$startPos = $isStart;
		$separPos = stripos($artSamples, $separPiece, $fromPos);
		$endPos = stripos($artSamples, $endPiece, $fromPos);
		if ($separPos!==false && $endPos!==false && $separPos > $startPos && $endPos > $separPos)
		{
			$beginPos = $startPos + strlen($startPiece);
			$sourceStr = substr($artSamples, $beginPos, $separPos - $beginPos);
			$beginPos = $separPos + strlen($separPiece);
			$resultStr = substr($artSamples, $beginPos, $endPos - $beginPos);
			
			$result[] = array($this->prepareArticlesDescr($sourceStr),$this->removeNextRows($resultStr));
			$fromPos = $endPos + 1;
			$isStart = stripos($artSamples, $startPiece, $fromPos);
		}
		else
		{
			$isStart = false;
		}
	}

	return $result;
  }
}
?>
