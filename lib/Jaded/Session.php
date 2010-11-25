<?php
/**
 * Central place for dealing with session issues
 */
interface Jaded_Session
{
	/**
	 * Initialize and open the session
	 */
	public function open();

	/**
	 * Close and write the session
	 */
	public function close();

	/**
	 * Destroy the session, and all associated data
	 */
	public function destroy();

	/**
	 * Set a value accessible with the given key
	 * @param string $sKey
	 * @param mixed $sValue
	 */
	public function setParam($sKey, $sValue);

	/**
	 * Return the named value
	 * @param string $sKey
	 * @return string
	 */
	public function getParam($sKey);
}

