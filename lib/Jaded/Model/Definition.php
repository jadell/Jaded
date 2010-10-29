<?php
/**
 * Define a model's available fields and keys
 */
abstract class Jaded_Model_Definition
{
	/**
	 * Singleton instances of definitions
	 */
	protected static $aInstances = array();

	/**
	 * Map of external field name => internal field name
	 * Override in concrete classes
	 */
	protected $aFieldMap = array();

	/**
	 * Map external field name to key type:
	 *   'auto' indicates an auto-incrementing key
	 *   'key' indicates part of a multi-part key
	 * Override in concrete classes
	 */
	protected $aKeyFields = array();

	/**
	 * Default values for fields not provided when model is instantiated
	 * Map external field name => value
	 * Override in concrete classes if necessary
	 */
	protected $aDefaultValues = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC //////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Returns an instance of the requested definition
	 * @param string $sType
	 * @return Jaded_Model_Definition
	 * @throws Jaded_Model_Exception if the type requested is an invalid definition
	 */
	public static function instance($sType)
	{
		if (empty(self::$aInstances[$sType])) {
			if (!is_subclass_of($sType, __CLASS__)) {
				throw new Jaded_Model_Exception("Invalid Model Definition type [{$sType}]", Jaded_Model_Exception::BadDefinitionType);
			}
			self::$aInstances[$sType] = new $sType();
		}
		return self::$aInstances[$sType];
	}

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Return the external field name for the auto increment key
	 * @return string or null if none defined
	 */
	public function getAutoKey()
	{
		foreach ($this->aKeyFields as $sField => $sType) {
			if ($sType == 'auto') {
				return $sField;
			}
		}
		return null;
	}

	/**
	 * Return the external => default value mapping
	 * @return array
	 */
	public function getDefaults()
	{
		return $this->aDefaultValues;
	}

	/**
	 * Return the external => internal field mapping
	 * @return array
	 */
	public function getFieldMap()
	{
		return $this->aFieldMap;
	}

	/**
	 * Get the internal field name for the given external name
	 * @param string $sExternalName
	 * @return string or null
	 */
	public function getInternalField($sExternalName)
	{
		return isset($this->aFieldMap[$sExternalName]) ? $this->aFieldMap[$sExternalName] : null;
	}

	/**
	 * Return the key fields
	 * @return array
	 */
	public function getKeys()
	{
		return $this->aKeyFields;
	}

	/**
	 * Determines if the given model is fully and uniquely identified
	 * @param Jaded_Model $oModel
	 * @return boolean
	 */
	public function isModelIdentified(Jaded_Model $oModel)
	{
		$aKeys = $this->aKeyFields;
		if (count($aKeys)<1) {
			return false;
		}

		foreach ($aKeys as $sField => $sTemp) {
			$sMethod = "get{$sField}";
			$mValue = $oModel->$sMethod();
			if ($mValue === null) {
				return false;
			}
		}
		return true;
	}
}
?>
