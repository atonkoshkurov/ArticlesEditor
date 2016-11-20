<html>
<head>
<meta charset="utf-8">
</head>
<body>
Алгоритм:
<br>
<?php
function getInnerText($fulltdtext)
{
	$result = '';
	$startsymbol ='>';
	$endpart = '</td>';
	
	$startPos = strpos($fulltdtext,$startsymbol)+1;
	$nextPos = strpos($fulltdtext,$endpart);
	$result = substr($fulltdtext, $startPos, $nextPos - $startPos);
	
	return $result;
}

function showNavigationContentHTML()
{
	$filename = "NavigatorMenuSamples.html";
	$htmldata = new DOMDocument();
	$htmldata->loadHTMLFile(dirname(__FILE__).'/'.$filename);
	$tbody_list = $htmldata->documentElement->getElementsByTagName('tbody'); 
	$tbody_node = $tbody_list[0];
	foreach($tbody_node->childNodes as $child)
	{
		if (strcmp($child->nodeName,'tr')===0)
		{
			$tdnodes = $child->getElementsByTagName('td');
			
			$tdnode = $tdnodes[0];
			$currentValue = $tdnodes[0]->nodeValue;
			$amountValue = $tdnodes[1]->nodeValue;
			
			$tdtext = $htmldata->saveHtml($tdnode[2]);
			
			echo '<br>';
			echo '<br>';
			echo '<plaintext>'.getInnerText($tdtext).'</plaintext>';
			
		}
	}	
}

function showNavigationContentXML()
{
	/**
	*$menuSamples = new SimpleXMLElement($filename);
	echo $menuSamples->order[0]->paymentType;
	*/
	$filename = "NavigatorMenuSamples.html";
	$menuSamples = simplexml_load_file(dirname(__FILE__).'/'.$filename);
	echo $menuSamples->table[0]->tbody;
}

echo getenv("COMPUTERNAME");

?>
</body>
</html>