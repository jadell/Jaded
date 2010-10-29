<?php
/**
 * Interface for finding a file based on a class name
 */
interface Jaded_Autoloader_Finder
{
	/**
	 * Determine a file path based on a class name
	 * @param string $sClassname
	 * @param string path to file containing class
	 */
	public function find($sClassname);
}
?>
