<?php
/**
* ArticleManager class - class for operating with database table 'Articles'
*
* @version 1.0
*/
Class ArticleManager
{
	private $dbtype;
	private $dbhost;
	private $dbname;	
	private $login;
	private $psw;
	
	const DB_CONNECTION_SETTINGS_FILE = 'dbconnection.ini';
	const TABLENAME = 'articles';
	
	function __construct()
	{
		FillConnectionParams();
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
	
	/**
	* Initialize connection parameters from file 'dbconnection.ini' 
	* @return void
	*/
	private function FillConnectionParams()
	{
		$dbarray = file(self::DB_CONNECTION_SETTINGS_FILE);
		$SetAmount = count($dbarray);
		$nm = 0;
		while ($nm < $SetAmount)
		{
			$dbstring = $dbarray[$nm];
			
			$nm = $nm + 1;
		}
	}
	
	/**
	* Reads string with database connection parameter description and saves it into separate variables "name" and "value" 
	* @return array 
	*/
	private function DecomposeParameter($parameterString)
	{
		$par_name = '';
		$par_value = '';
		$pos = strpos($parameterString,':');
		$posend = strpos($parameterString,';');
		if ($pos > 0 && $posend > $pos)
		{
			$par_name = trim(substr($parameterString,0,$pos));
			$par_value = trim(substr($parameterString,$pos+1,$posend - $pos - 1));
		}
		$result = ["name" => $par_name, "value" => $par_value];
		return $result;
	}
}
?>