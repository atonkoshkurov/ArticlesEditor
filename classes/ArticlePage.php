<?php
namespace ArticlesEdition
{
/**
* ArticlePage class - class for article page controlling
*
* @version 1.0
*/
Class ArticlePage
{
	/**
	* @var int $CurrentArticleNumber article number chosen by user
	*/	
	private $CurrentArticleNumber;
	
	/**
	* @var ActionTypes $ActionType type of action processing by user
	*/
	private $ActionType;
	
	/**
	* @var string $ArticleTitle title of current article
	*/
	private $ArticleTitle;
	
	/**
	* @var string $ArticleBody the content of current article
	*/
	private $ArticleBody;
	
	/**
	* @var int $ArticleId the identificator of current existing (not new) article. 
	* For new article this variable is undefined.
	*/
	private $ArticleId;
	
	/**
	* @var PictureDescription[] $PictureList list of picture descriptions 
	* (attributes and binary data of each picture of current article)
	*/
	private $PictureList;
	
	/**
	* @var int $ArticleAmount amount of articles
	*/
	private $ArticleAmount;
	
	/**
	* @var int $PageNumber number of current page
	*/
	private $PageNumber;
	
	/**
	* @var int $FirstArticleOnPage number of first article on current page
	*/
	private $FirstArticleOnPage;
	
	/**
	* @var int $LastArticleOnPage number of last article on current page
	*/
	private $LastArticleOnPage;

	/**
	* Passes current article number to the class from an incoming parameter
	* @param int $currentNumber
	* @return void
	*/
	public function SetCurrentArticleNumber($currentNumber) 
	{
		
	}
	
	/**
	* Passes action type, article body and title to a new article (when adding) or existing with
	* current article id
	* @param ActionTypes $actionType
	* @param int $articleId
	* @param string $articleBody
	* @param string $actionTitle
	* @return void
	*/
	public function SetArticleAction($actionType, $articleId, $articleBody, $actionTitle)
	{
		
	}
	
	/**
	* Saves in class instance pictures list of the current article
	* @param PictureDescription[] $pList
	* @return void
	*/
	public function SetPictureList($pList)
	{
		
	}
	
	/**
	* Generates the content of page from class parameters
	* @return string
	*/
	public function GetPageResult()
	{
		
	}
	
	/**
	* Saves new article to site database (id, title) and file system (content)
	* @return void
	*/
	private function AddArticle()
	{
		
	}

	/**
	* Saves edited existing article to site database and file system
	* @return void
	*/
	private function EditArticle()
	{
		
	}
	
	/**
	* Removes existing article from site database and file system
	* @return void
	*/
	private function RemoveArticle()
	{
		
	}
	
	/**
	* Calculates a new number of current article after some action with articles
	* @return void
	*/
	private function CalculateCurrentArticleNumber()
	{
		
	}
	
	/**
	* Calculates parameters 'PageNumber', 'FirstArticleOnPage', 'LastArticleOnPage' depending on
	* current article number and constant parameter 'AmountOfArticlesOnPage'
	* @return void
	*/
	private function CalculatePageParams()
	{
		
	}
	
}
}
?>