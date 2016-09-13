<?php
/**
* InputTreatment class - parent class for creating common set of input parameters from post and session parameters
* for each page a child class must be made with its own set of page parameters  
*
* @version 1.0
*/
class InputTreatment
{
	/**
	* Defines the source of parameters and fills them in common set
	* @return void
	*/	
	static public function treatInParams() 
	{
		
	}
	
	/**
	* Fills the common set of parameters with post parameters
	* @return void
	*/
	static private function treatClientParams()
	{
		
	}
	
	/**
	* Fills the common set of parameters with session parameters
	* @return void
	*/
	static private function treatSessionParams()
	{
		
	}
}
?>