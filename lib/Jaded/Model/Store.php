<?php
/**
 * Handles storage and retrieval of data
 * Basic CRUD operations and any developer-defined data access (listing, linking, etc.)
 */
abstract class Jaded_Model_Store
{
	/**
	 * Singleton instances of stores
	 */
	protected static $aInstances = array();

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC //////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Returns an instance of the requested store
	 * @param string $sType
	 * @return Jaded_Model_Store
	 * @throws Jaded_Model_Exception if the type requested is an invalid store
	 */
	public static function instance($sType)
	{
		if (empty(self::$aInstances[$sType])) {
			if (!is_subclass_of($sType, __CLASS__)) {
				throw new Jaded_Model_Exception("Invalid Model Store type [{$sType}]", Jaded_Model_Exception::BadStoreType);
			}
			self::$aInstances[$sType] = new $sType();
		}
		return self::$aInstances[$sType];
	}

	////////////////////////////////////////////////////////////////////////////////
	// ABSTRACT ///////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Create the given model in the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is already fully identified (has a unique id)
	 */
	abstract public function create(Jaded_Model $oModel);

	/**
	 * Delete the given model from the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 */
	abstract public function delete(Jaded_Model $oModel);

	/**
	 * Load the given model from the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 * @throws Jaded_Model_Exception if identified model not found in store
	 */
	abstract public function load(Jaded_Model $oModel);

	/**
	 * Update the given model's data in the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 */
	abstract public function update(Jaded_Model $oModel);
}
