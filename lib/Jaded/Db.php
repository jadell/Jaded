<?php
/**
 * Class for connecting to databases
 */
abstract class Jaded_Db
{
	protected static $aConnections = array();

	//////////////////////////////////////////////////////////////////////
	// PUBLIC STATIC ////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Retrieve a named connection
	 * @param string $sName
	 * @return Jaded_Db
	 */
	public static function conn($sName)
	{
		if (empty(self::$aConnections[$sName])) {
			throw new Jaded_Db_Exception("No database connection found [{$sName}]", Jaded_Db_Exception::InvalidConnection);
		}
		return self::$aConnections[$sName];
	}

	/**
	 * Set a named connection
	 * @param string $sName
	 * @param Jaded_Db $oDb
	 */
	public static function set($sName, Jaded_Db $oDb)
	{
		self::$aConnections[$sName] = $oDb;
	}

	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Execute a SQL insert, update, or delete query
	 * @param string $sSql
	 * @param array  $aParams
	 * @return bool int number of affected rows
	 */
	abstract public function execute($sSql, $aParams=array());

	/**
	 * Return the results of a select query
	 * @param string $sSql
	 * @param array  $aParams
	 * @return array each element is an array representing a data row
	 */
	abstract public function getAll($sSql, $aParams=array());

	/**
	 * Retrieve the last id generated by an insert
	 * @return mixed
	 */
	abstract public function getLastInsertId();

	/**
	 * Return the first column of the first row from the results of a select query
	 * @param string $sSql
	 * @param array  $aParams
	 * @return string
	 */
	abstract public function getOne($sSql, $aParams=array());

	/**
	 * Return the first row from the results of a select query
	 * @param string $sSql
	 * @param array  $aParams
	 * @return array a single data row
	 */
	abstract public function getRow($sSql, $aParams=array());
}
?>