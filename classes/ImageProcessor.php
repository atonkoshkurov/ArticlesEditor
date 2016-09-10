<?php
/**
* ImageProcessor class - class for image processing 
*
* @version 1.0
*/
class ImageProcessor
{
	/**
	* Creates image file in the article folder from out address
	* @param int $articleId article identifier
	* @param int $nmb the number of picture
	* @param string $outFile the out address of chosen file
	* @return void
	*/	
	static public function MakeLocalFile($articleId, $nmb, $outFile) 
	{
		
	}
	
	/**
	* Creates image file in the article folder from binary data
	* @param int $articleId article identifier
	* @param int $nmb the number of picture
	* @param string $imageData binary data of picture
	* @return void
	*/	
	static public function MakeLocalFileFromData($articleId, $nmb, $imageData) 
	{
		
	}
	
	/**
	* Creates image binary data from out picture 
	* @param string $outFile the out address of file
	* @return string
	*/
	static public function MakeImageData($outFile) 
	{
		
	}
	
	/**
	* Verifies that picture file is correct   
	* @param string $outFile the out address of file
	* @return string
	*/
	static public function CheckImageFile($outFile) 
	{
		
	}
}
?>