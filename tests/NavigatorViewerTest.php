<?php
 
require_once(dirname(__FILE__).'/../classes/NavigatorViewer.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\NavigatorViewer;

class NavigatorViewerTest extends TestCase
{
  /**
  * @var string $pageAddress articles list page address
  */
  private static $pageAddress = 'NavigatorMenuSamples.html';
  
  /**
  * @var int $pageVolume article's amount on a page
  */
  private static $pageVolume = 5;
  
  /**
  * @var string $testDataFile file with test parameters
  */
  private static $testDataFile = 'NavigatorMenuSamples.html';
  
  protected function setUp() {}
  
  protected function tearDown(){ }
 
  /**
  * Gets inner tag text as is
  * @param string $fulltdtext full tag text
  * @return array 
  */
  private function getInnerText($fulltdtext)
{
	$result = '';
	$startsymbol ='>';
	$endpart = '</td>';
	
	$startPos = strpos($fulltdtext,$startsymbol)+1;
	$nextPos = strpos($fulltdtext,$endpart);
	$result = substr($fulltdtext, $startPos, $nextPos - $startPos);
	
	return $result;
}
 
  /**
  * @dataProvider getNavigatorParams
  */
  public function testShowNavigator($currentArticle, $articleAmount, $sampleNavigatorText)
  {
     $navigatorText = NavigatorViewer::ShowNavigator(self::$pageVolume,$currentArticle,$articleAmount,self::$pageAddress);
	 $this->assertEquals($navigatorText,$sampleNavigatorText); 
  }

  public function getNavigatorParams() 
  {
  	$result = array();	
	
	$htmldata = new DOMDocument('4.0','UTF-8');
	$htmldata->loadHTMLFile(dirname(__FILE__).'/'.self::$testDataFile);
	$tbody_list = $htmldata->documentElement->getElementsByTagName('tbody'); 
	$tbody_node = $tbody_list[0];	
	
	foreach($tbody_node->childNodes as $child)
		if (strcmp($child->nodeName,'tr')===0)
		{
			$tdnodes = $child->getElementsByTagName('td');			
			$currentValue = $tdnodes[0]->nodeValue;
			$amountValue = $tdnodes[1]->nodeValue;			
			$tdtext = $htmldata->saveHtml($tdnodes[2]);
			$sampleString = $this->getInnerText($tdtext);
			
			$result[] = array($currentValue,$amountValue,$sampleString);			
		}
	
	return $result;
  }
}
?>
