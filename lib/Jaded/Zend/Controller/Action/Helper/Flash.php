<?php
class Jaded_Zend_Controller_Action_Helper_Flash extends Zend_Controller_Action_Helper_Abstract
{
	public function success($sMessage)
	{
		$oMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$oMessenger->setNamespace('success');
		$oMessenger->addMessage($sMessage);
	}	

	public function error($sMessage)
	{
		$oMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$oMessenger->setNamespace('error');
		$oMessenger->addMessage($sMessage);
	}	
}

