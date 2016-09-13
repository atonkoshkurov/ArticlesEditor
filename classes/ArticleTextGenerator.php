<?php
/**
* ArticleTextGenerator class - class for generating article text from article body and backwards 
*
* @version 1.0
*/
class ArticleTextGenerator
{
	/**
	* Generates final text from raw body
	* @param int $articleId the identificator of current article
	* @param string $articleBody the content of current article
	* @param PictureDescription[] $pictureList list of picture descriptions
	* @param PictureTypes $pictureType a type of picture source (from file, from data)
	* @return string
	*/	
	static public function GenerateText($articleId, $articleBody, $pictureList, $pictureType) 
	{
		
	}
	
	/**
	* Generates initial body from text
	* @param string $articleText text as it is shown to end user
	* @param PictureDescription[] $pictureList list of picture descriptions
	* @return string
	*/
	static public function GenerateBodyAndPictures($articleText, &$pictureList)
	{
		
	}
}
?>