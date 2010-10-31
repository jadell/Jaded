<?php
/**
 * Encapsulates all data for a request
 */
class Jaded_Request
{
	protected $aParams = array();
	protected $sControllerName = '';

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Retrieve the name of the controller handling this request
	 * @return string
	 */
	public function getControllerName()
	{
		return $this->sControllerName;
	}

	/**
	 * Set the name of the controller that should handle this request
	 * @param string $sName
	 */
	public function setControllerName($sName)
	{
		$this->sControllerName = $sName;
	}

	/**
	 * Retrieve a request parameter
	 * @param string $sName
	 * @return mixed
	 */
	public function getParam($sName)
	{
		return isset($this->aParams[$sName]) ? $this->aParams[$sName] : null;
	}

	/**
	 * Set a request parameter
	 * @param string $sName
	 * @param mixed $mValue
	 */
	public function setParam($sName, $mValue)
	{
		$this->aParams[$sName] = $mValue;
	}
}
?>