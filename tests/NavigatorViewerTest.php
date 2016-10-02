<?php
 
require_once(dirname(__FILE__).'/../classes/NavigatorViewer.php');
use PHPUnit\Framework\TestCase; 
use ArticlesEdition\NavigatorViewer;

class NavigatorViewerTest extends TestCase
{
  public function setUp(){ }
  public function tearDown(){ }
 
  /**
  * @dataProvider getNavigatorParams
  */
  public function testShowNavigator($currentArticle, $articleAmount, $sampleNavigatorText)
  {
      
  }

  public function getNavigatorParams() 
  {
  		
  }
}
?>
