<?php
/**
 * Encapsulates all data for a request
 */
class Jaded_Request
{
	const MethodGet    = 'GET';
	const MethodPost   = 'POST';
	const MethodPut    = 'PUT';
	const MethodDelete = 'DELETE';

	protected $aParams = array();
	protected $sControllerName = '';
	protected $sMethod = self::MethodGet;

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
	 * Set the method type
	 * @param string $sMethod
	 */
	public function setMethod($sMethod)
	{
		$sMethod = strtoupper($sMethod);
		if (!in_array($sMethod, $this->getValidMethods())) {
			throw new Jaded_Exception("Invalid request method type [$sMethod]");
		}

		$this->sMethod = $sMethod;
	}

	/**
	 * Retrieve the set method type
	 * @return string
	 */
	public function getMethod()
	{
		return $this->sMethod;
	}

	/**
	 * What method is this request?
	 * @return boolean
	 */
	public function isGet()    { return (self::MethodGet    == $this->sMethod); }
	public function isPost()   { return (self::MethodPost   == $this->sMethod); }
	public function isPut()    { return (self::MethodPut    == $this->sMethod); }
	public function isDelete() { return (self::MethodDelete == $this->sMethod); }

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

	////////////////////////////////////////////////////////////////////////////////
	// PROTECTED //////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Get the valid method types
	 * @return array
	 */
	protected function getValidMethods()
	{
		return array(
			self::MethodGet,
			self::MethodPost,
			self::MethodPut,
			self::MethodDelete,
		);
	}
}
