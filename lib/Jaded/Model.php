<?php
/**
 * Hold model data, it's definition and how to store it
 */
abstract class Jaded_Model
{
	/**
	 * Class name of the Model_Definition to use
	 * Override in concrete classes
	 */
	protected $sDefaultDefinition = 'Jaded_Model_Definition';

	/**
	 * Class name of the Model_Store to use
	 * Override in concrete classes
	 */
	protected $sDefaultStore      = 'Jaded_Model_Store';


	protected $oDef = null;
	protected $oStore = null;

	protected $aValues = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Build a new model
	 * @param mixed $mData can be an array of data to populate with or another Jaded_Model to clone
	 * @param Jaded_Model_Definition $oDef if not given will create from self::$sDefaultDefinition
	 * @param Jaded_Model_Store $oStore if not given will create from self::$sDefaultStore
	 */
	public function __construct($mData=null, Jaded_Model_Definition $oDef=null, Jaded_Model_Store $oStore=null)
	{
		if ($oDef !== null) {
			$this->oDef = $oDef;
		}
		if ($oStore !== null) {
			$this->oStore = $oStore;
		}

		$aDefaults = $this->getModelDefinition()->getDefaults();
		$aGivens = array();
		if (is_array($mData)) {
			$aGivens = $mData;
		} else if ($mData instanceof Jaded_Model) {
			$aGivens = $mData->asArray();
		}
		$aValues = array_merge($aDefaults, $aGivens);
		$this->fromArray($aValues);
	}

	/**
	 * Save this model in the data store
	 */
	public function create()
	{
		return $this->getModelStore()->create($this);
	}

	/**
	 * Delete this model from the data store
	 */
	public function delete()
	{
		return $this->getModelStore()->delete($this);
	}

	/**
	 * Load this model with data from the data store
	 */
	public function load()
	{
		return $this->getModelStore()->load($this);
	}

	/**
	 * Update this model in the data store
	 */
	public function update()
	{
		return $this->getModelStore()->update($this);
	}

	/**
	 * Get the model's data as an array of values
	 * @return array
	 */
	public function asArray()
	{
		$aReturn = array();
		$aFields = $this->getModelDefinition()->getFieldMap();
		foreach ($aFields as $sFieldName => $sInternalField) {
			$aReturn[$sFieldName] = $this->get($sFieldName);
		}
		return $aReturn;
	}

	/**
	 * Load the model from an array of values
	 * @param array $aValues
	 */
	public function fromArray($aValues)
	{
		foreach ($aValues as $sFieldName => $mValue) {
			$this->set($sFieldName, $mValue);
		}
	}

	/**
	 * Is this model fully and uniquely identified?
	 * @return boolean
	 */
	public function isIdentified()
	{
		return $this->getModelDefinition()->isModelIdentified($this);
	}

	/**
	 * Return the model definition used by this model
	 * @return Jaded_Model_Definition
	 */
	public function getModelDefinition()
	{
		if ($this->oDef == null) {
			$this->oDef = Jaded_Model_Definition::instance($this->sDefaultDefinition);
		}
		return $this->oDef;
	}

	/**
	 * Return the model store used by this model
	 * @return Jaded_Model_Store
	 */
	public function getModelStore()
	{
		if ($this->oStore == null) {
			$this->oStore = Jaded_Model_Store::instance($this->sDefaultStore);
		}
		return $this->oStore;
	}

	////////////////////////////////////////////////////////////////////////////////
	// MAGIC //////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Magic call to get and set key:value pairs
	 * @param string $sMethodName
	 * @param array  $aArgs
	 * @return mixed
	 */
	public function __call($sMethodName, $aArgs)
	{
		$sMethodName = strtolower($sMethodName);
		$sGetSetCheck = substr($sMethodName, 0, 3);
		$sFieldName = substr($sMethodName, 3);

		if ($sGetSetCheck == 'set' || $sGetSetCheck == 'get') {
			if ($sGetSetCheck == 'set') {
				$this->set($sFieldName, $aArgs[0]);
			} else {
				return $this->get($sFieldName);
			}
		} else {
			$this->throwInvalidMethodException($sMethodName);
		}
	}

	////////////////////////////////////////////////////////////////////////////////
	// PROTECTED //////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Get a value
	 * @param string $sFieldName
	 * @return mixed
	 */
	protected function get($sFieldName)
	{
		$sInternalField = $this->getInternalField($sFieldName, 'get');
		return isset($this->aValues[$sInternalField]) ? $this->aValues[$sInternalField] : null;
	}

	/**
	 * Set a value
	 * @param string $sFieldName
	 * @param mixed  $mValue
	 */
	protected function set($sFieldName, $mValue)
	{
		$sInternalField = $this->getInternalField($sFieldName, 'set');
		$this->aValues[$sInternalField] = $mValue;
	}

	/**
	 * Map an external field name to an internal
	 * @param string $sFieldName
	 * @param string $sPrefix
	 * @return string
	 * @throws Jaded_Model_Exception
	 */
	protected function getInternalField($sFieldName, $sPrefix)
	{
		$sInternalField = $this->getModelDefinition()->getInternalField($sFieldName);
		if (!$sInternalField) {
			$this->throwInvalidMethodException($sPrefix.$sMethodName);
		}
		return $sInternalField;
	}

	/**
	 * Throw an invalid method exception
	 * @param string $sMethodName
	 * @throws Jaded_Model_Exception
	 */
	protected function throwInvalidMethodException($sMethodName)
	{
		$sClass = get_class($this);
		throw new Jaded_Model_Exception("Method [{$sMethodName}] does not exist in Model [{$sClass}]", Jaded_Model_Exception::InvalidMethod);
	}
}
?>