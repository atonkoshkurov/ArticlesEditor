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
  
  protected function setUp() { }
  
  protected function tearDown(){ }
 
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
	
	$htmldata = new DOMDocument();
	$htmldata->loadHTMLFile(dirname(__FILE__).'/'.self::$testDataFile);
	$tbody_list = $htmldata->documentElement->getElementsByTagName('tbody'); 
	$tbody_node = $tbody_list[0];	
	
	foreach($tbody_node->childNodes as $child)
		if (strcmp($child->nodeName,'tr')===0)
		{
			foreach($child->childNodes as $tdnode)
			{
				if (strcmp($tdnode->nodeName,'td')===0)
				{
					if ($tdnode->hasChildNodes())
					{
						/**foreach($tdnode->childNodes as $txtnode)
						*$result[] = array(0,$txtnode->nodeName,$txtnode->nodeValue);
						*/
					}
				}
				else
				{					
					
				}
				$result[] = array(0,$tdnode->nodeName,$tdnode->nodeValue);
			}
			break;
		}
	
	return $result;
  }
}
?>
