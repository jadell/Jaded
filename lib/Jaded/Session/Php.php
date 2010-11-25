<?php
/**
 * Handle sessions using PHP's built in session handling
 */
class Jaded_Session_Php implements Jaded_Session
{
	//////////////////////////////////////////////////////////////////////
	// PUBLIC ///////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Initialize and open the session
	 */
	public function open()
	{
		session_start();
	}

	/**
	 * Close and write the session
	 */
	public function close()
	{
		session_write_close();
	}

	/**
	 * Destroy the session, and all associated data
	 */
	public function destroy()
	{
		$_SESSION = array();
		$this->clearSessionCookie();
		session_destroy();
	}

	/**
	 * Set a value accessible with the given key
	 * @param string $sKey
	 * @param mixed $sValue
	 */
	public function setParam($sKey, $sValue)
	{
		$_SESSION[$sKey] = $sValue;
	}

	/**
	 * Return the named value
	 * @param string $sKey
	 * @return string
	 */
	public function getParam($sKey)
	{
		return isset($_SESSION[$sKey]) ? $_SESSION[$sKey] : null;
	}

	//////////////////////////////////////////////////////////////////////
	// PROTECTED ////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Clear out the session cookie if necessary
	 */
	protected function clearSessionCookie()
	{
		if (ini_get("session.use_cookies")) {
			$aParams = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$aParams["path"], $aParams["domain"],
				$aParams["secure"], $aParams["httponly"]);
		}
	}

}

