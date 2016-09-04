<?php
/**
* PictureDescription class - structure of parameters describing a picture in article 
*
* @version 1.0
*/
class PictureDescription
{
	/**
	* @var string $pictureData path to picture file or binary data in base64 format
	*/	
	public $pictureData;
	
	/**
	* @var int $x horizontal size
	*/	
	public $x;
	
	/**
	* @var int $y vertical size
	*/
	public $y;
	
	/**
	* @var Measures $measure measure unit
	*/
	public $measure;
}
?>