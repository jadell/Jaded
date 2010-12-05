<?php
/**
 * Provide database CRUD operations for models
 */
abstract class Jaded_Model_Store_Database extends Jaded_Model_Store
{
	/**
	 * Table name
	 * Override in concrete classes
	 */
	protected $sTable = '';

	/**
	 * DB name
	 * Override in concrete classes
	 */
	protected $sDbId = '';

	////////////////////////////////////////////////////////////////////////////////
	// PUBLIC /////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Create the given model in the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is already fully identified (has a unique id)
	 */
	public function create(Jaded_Model $oModel)
	{
		if ($oModel->isIdentified()) {
			throw new Jaded_Model_Exception('Model could not be created; already identified.', Jaded_Model_Exception::ModelIdentified);
		}

		$oDb = Jaded_Db::conn($this->sDbId);
		$oDef = $oModel->getModelDefinition();

		$aParams = array();
		$aFields = array_unique($oDef->getFieldMap());
		foreach ($aFields as $sExternal => $sInternal) {
			$sMethod = "get{$sExternal}";
			$aParams[] = $oModel->$sMethod();
		}
		$sFields = join(',', $aFields);
		$sPlaceholders = join(',', array_fill(0, count($aFields), '?'));

		$sSql = "INSERT INTO {$this->sTable} ({$sFields}) VALUES ({$sPlaceholders})";
		$oDb->execute($sSql, $aParams);

		$sAutoKey = $oDef->getAutoKey();
		if ($sAutoKey) {
			$sMethod = "set{$sAutoKey}";
			$iAutoId = $oDb->getLastInsertId();
			$oModel->$sMethod($iAutoId);
		}
	}

	/**
	 * Delete the given model from the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 */
	public function delete(Jaded_Model $oModel)
	{
		if (!$oModel->isIdentified()) {
			throw new Jaded_Model_Exception('Model could not be deleted; not identified.', Jaded_Model_Exception::ModelNotIdentified);
		}

		list($sWhere, $aParams) = $this->constructWhere($oModel);
		$sSql = "DELETE FROM {$this->sTable} WHERE {$sWhere}";
		Jaded_Db::conn($this->sDbId)->execute($sSql, $aParams);
	}

	/**
	 * Load the given model from the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 * @throws Jaded_Model_Exception if identified model not found in store
	 */
	public function load(Jaded_Model $oModel)
	{
		if (!$oModel->isIdentified()) {
			throw new Jaded_Model_Exception('Model could not be loaded; not identified.', Jaded_Model_Exception::ModelNotIdentified);
		}

		list($sWhere, $aParams) = $this->constructWhere($oModel);
		$sSql = "SELECT * FROM {$this->sTable} WHERE {$sWhere}";
		$aData = Jaded_Db::conn($this->sDbId)->getRow($sSql, $aParams);
		if (!$aData) {
			throw new Jaded_Model_Exception('Model could not be loaded; not found.', Jaded_Model_Exception::NotFoundInStore);
		}

		$aFlipMap = array_flip($oModel->getModelDefinition()->getFieldMap());
		foreach ($aFlipMap as $sInternal => $sExternal) {
			$sMethod = "set{$sExternal}";
			$oModel->$sMethod($aData[$sInternal]);
		}
	}

	/**
	 * Update the given model's data in the data store
	 * @param Jaded_Model $oModel
	 * @throws Jaded_Model_Exception if the model given is not fully identified
	 */
	public function update(Jaded_Model $oModel)
	{
		if (!$oModel->isIdentified()) {
			throw new Jaded_Model_Exception('Model could not be updated; not identified.', Jaded_Model_Exception::ModelNotIdentified);
		}

		$oDef = $oModel->getModelDefinition();
		$aKeys = $oDef->getKeys();
		$aFields = $oDef->getFieldMap();
		foreach ($aFields as $sExternal => $sInternal) {
			if (isset($aKeys[$sExternal])) {
				unset($aFields[$sExternal]);
			}
		}
		$aFields = array_unique($aFields);

		$aSets = array();
		$aUpdates = array();
		foreach ($aFields as $sExternal => $sInternal) {
			$sMethod = "get{$sExternal}";
			$aUpdates[] = $oModel->$sMethod();
			$aSets[] = "{$sInternal}=?";
		}
		$sSets = join(',', $aSets);

		list($sWhere, $aParams) = $this->constructWhere($oModel);
		$aParams = array_merge($aUpdates, $aParams);
		$sSql = "UPDATE {$this->sTable} SET {$sSets} WHERE {$sWhere}";
		$aData = Jaded_Db::conn($this->sDbId)->execute($sSql, $aParams);
	}

	////////////////////////////////////////////////////////////////////////////////
	// PROTECTED //////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	/**
	 * Construct a SQL WHERE clause for the given model
	 * @param Jaded_Model $oModel
	 * @return array (SQL clause, array(params))
	 */
	protected function constructWhere($oModel)
	{
		$oDef = $oModel->getModelDefinition();
		$aFields = $oDef->getFieldMap();
		$aKeys = $oDef->getKeys();

		$aWhere = array();
		$aParams = array();
		foreach ($aKeys as $sExternal => $sType) {
			$sInternal = $aFields[$sExternal];
			$aWhere[] = "{$sInternal}=?";

			$sMethod = "get{$sExternal}";
			$aParams[] = $oModel->$sMethod();
		}
		$sWhere = join(' AND ', $aWhere);
		return array($sWhere, $aParams);
	}
}
