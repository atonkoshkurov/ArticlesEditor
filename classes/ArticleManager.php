<?php
namespace ArticlesEdition
{
require_once('DBConnector.php');
require_once('ArticleManagerException.php');
use DBConnector;
use ArticleManagerException;

/**
* ArticleManager class - class for operating with database table 'Articles'
*
* @version 1.0
*/
Class ArticleManager
{
	private $localpdo;
	
	/** const DB_CONNECTION_SETTINGS_FILE = 'dbconnection.ini'; */
	const TABLENAME = 'articles';
	
	function __construct($db_connection)
	{
		$this->localpdo = $db_connection;
	}
	
	/**
	* Adds (register only, without content) new article 
	* @param string $title
	* @return int
	*/	
	public function add($title) 
	{
		$conn = $this->localpdo->startConnection();
		$sqltext = 'Insert into '.self::TABLENAME.'(title) values( ? );';
		$stmt = $conn->prepare($sqltext);
		$stmt->execute(array($title));
		$artId = $conn->lastInsertId();		
		
		$this->localpdo->closeConnection($conn);
		return $artId;
	}
	
	/**
	* Edits title of an article with 'id' 
	* @param int $id
	* @param string $title
	* @return void
	*/
	public function edit($id, $title) 
	{
		
	}
	
	/**
	* Removes an article with 'id' 
	* @param int $id
	* @return void
	*/
	public function remove($id) 
	{
		
	}
	
	/**
	* Gets the amount of articles 
	* @return int
	*/
	public function getAmount() 
	{
		
	}
	
	/**
	* Gets the list of article descriptions from 'first' to 'last' (by sequence number, not id)
	* passing 0 values means requesting all the list
	* @param int $first
	* @param int $last
	* @return ArticleDescription[]
	*/
	public function getList($first = 0, $last = 0) 
	{
		
	}
	
	/**
	* Gets an article description with 'id'
	* @param int $id 
	* @return ArticleDescription
	*/
	public function getArticle($id) 
	{
	
	}
}
}
?>
