<?php
class Jaded_Zend_View_Helper_Flash extends Zend_View_Helper_Abstract
{
	public function flash($sType)
	{
		$oMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$oMessenger->setNamespace($sType);
		return $oMessenger->getMessages();
	}
}
