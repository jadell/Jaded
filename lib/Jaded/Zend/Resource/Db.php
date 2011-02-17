<?php

class Jaded_Zend_Resource_Db extends Zend_Application_Resource_ResourceAbstract
{
	public function init()
	{
		$oConfig = $this->getBootstrap()->getResource('config');
		$aDsns = $oConfig->jaded->db->toArray();
		foreach ($aDsns as $sName => $sDsn) {
			$oDb = new Jaded_Db_Pdo($sDsn);
			Jaded_Db::set($sName, $oDb);
		}
	}
}

