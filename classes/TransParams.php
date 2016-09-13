<?php
/**
* TransParams class - class for translation of post parameters to session parameters 
*
* @version 1.0
*/
class TransParams
{
	/**
	* Creates and writes session parameters
	* @param ActionTypes $actionType type of action processing by user
	* @param int $articleId the identificator of current article
	* @param string $articleTitle title of current article
	* @param string $articleBody the content of current article
	* @param PictureDescription[] $pictureList list of picture descriptions
	* @return void
	*/	
	static public function GenerateSessionParams($actionType, $articleId, $articleTitle, $articleBody, $pictureList) 
	{
		
	}
}
?>