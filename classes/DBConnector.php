<?php
namespace ArticlesEdition
{
	
use \PDO;
use \PDOException;
/**
* ArticleManager class - class for operating with database table 'Articles'
*
* @version 1.0
*/
Class DBConnector
{
	private $dbtype;
	private $dbhost;
	private $dbname;	
	private $login;
	private $psw;
	
	/**
	* @param string $dbsettingsfile path to file with database connection parameters 
	*/
	function __construct($dbsettingsfile)
	{
		$this->fillConnectionParams($dbsettingsfile);
	}
	
	/**
	* Creates new connection 
	* @return PDO
	*/
	public function startConnection()
    {		
		$dsn = $this->dbtype.":host=".$this->dbhost.";dbname=".$this->dbname;
		$result = new PDO($dsn,$this->login,$this->psw);
		$result->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $result;
	}
	
	/**
	* Closes connection 
	* @param PDO $dbconnection database connection
	* @return void
	*/
	public function closeConnection($dbconnection)
	{
		$dbconnection = null;
	}
	
	/**
	* Initializes connection parameters from ini file 
	* @param string $dbsettingsfile path to file with database connection parameters
	* @return void
	*/
	private function fillConnectionParams($dbsettingsfile)
	{
		$dbarray = file($dbsettingsfile);
		$SetAmount = count($dbarray);
		$nm = 0;
		while ($nm < $SetAmount)
		{
			$db_connection_param = $this->decomposeParameter($dbarray[$nm]);
			if (strcmp($db_connection_param["name"],'DBEngine') === 0)
			{
				$this->dbtype = $db_connection_param["value"];
			} elseif (strcmp($db_connection_param["name"],'DBHost') === 0)
			{
				$this->dbhost = $db_connection_param["value"];
			} elseif (strcmp($db_connection_param["name"],'DBName') === 0)
			{
				$this->dbname = $db_connection_param["value"];
			} elseif (strcmp($db_connection_param["name"],'DBUser') === 0)
			{
				$this->login = $db_connection_param["value"];
			} elseif (strcmp($db_connection_param["name"],'DBPsw') === 0)
			{
				$this->psw = $db_connection_param["value"];
			}
			
			$nm = $nm + 1;
		}
	}
	
	/**
	* Reads string with database connection parameter description and saves it into separate variables "name" and "value"
	* @param string $parameterString parameter description
	* @return array 
	*/
	protected function decomposeParameter($parameterString)
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
}
?>