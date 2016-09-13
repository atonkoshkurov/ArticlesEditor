<?php
/**
* ArticleManager class - class for operating with database table 'Articles'
*
* @version 1.0
*/
Class ArticleManager
{
	private $dbname;
	private $tablename;
	private $login;
	private $psw;
	
	function __construct()
	{
		
	}
	
	/**
	* Adds (register only, without content) new article 
	* @param string $title
	* @return int
	*/	
	public function Add($title) 
	{
		
	}
	
	/**
	* Edits title of an article with 'id' 
	* @param int $id
	* @param string $title
	* @return void
	*/
	public function Edit($id, $title) 
	{
		
	}
	
	/**
	* Removes an article with 'id' 
	* @param int $id
	* @return void
	*/
	public function Remove($id) 
	{
		
	}
	
	/**
	* Gets the amount of articles 
	* @return int
	*/
	public function GetAmount() 
	{
		
	}
	
	/**
	* Gets the list of all article descriptions
	* @return ArticleDescription[]
	*/
	public function GetList() 
	{
		
	}
	
	/**
	* Gets the list of article descriptions from 'first' to 'last' (by sequence number, not id)
	* @param int $first
	* @param int $last
	* @return ArticleDescription[]
	*/
	public function GetList($first, $last) 
	{
		
	}
	
	/**
	* Gets an article description with 'id'
	* @param int $id 
	* @return ArticleDescription
	*/
	public function GetArticle($id) 
	{
	
	}
}
?>