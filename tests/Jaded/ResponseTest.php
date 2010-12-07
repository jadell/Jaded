<?php
class Jaded_ResponseTest extends PHPUnit_Framework_TestCase
{
	public function testAssignment()
	{
		$oResponse = new Jaded_Response();
		$aExpected = array(
			'sName' => 'some value',
			'aSomeArray' => array(1,2,3),
			'oObject' => new stdClass()
		);

		foreach ($aExpected as $sKey => $mValue) {
			$oResponse->assign($sKey, $mValue);
		}

		$aResult = $oResponse->getAssigns();
		$this->assertEquals($aExpected, $aResult);
	}

	public function testHeaders()
	{
		$oResponse = new Jaded_Response();
		$aExpected = array(
			'Content-Type' => 'some value',
			'Application-Header' => 'I made this up',
		);

		foreach ($aExpected as $sKey => $sValue) {
			$oResponse->header($sKey, $sValue);
		}

		$aResult = $oResponse->getHeaders();
		$this->assertEquals($aExpected, $aResult);
	}

	public function testRedirect()
	{
		$oResponse = new Jaded_Response();
		$this->assertFalse($oResponse->isRedirected());

		$aExpected = array(
			'Location' => 'new location',
		);
		$oResponse->redirect($aExpected['Location']);

		$aResult = $oResponse->getHeaders();
		$this->assertEquals($aExpected, $aResult);
		$this->assertTrue($oResponse->isRedirected());
	}

	public function testTemplate_NamedTemplateSet_ReturnsNamedTemplate()
	{
		$oResponse = new Jaded_Response();
		$oResponse->setTemplate('templatename', '/some/template');
		$this->assertEquals('/some/template', $oResponse->getTemplate('templatename'));
	}

	public function testTemplate_NamedTemplateNotSet_ReturnsNull()
	{
		$oResponse = new Jaded_Response();
		$this->assertNull($oResponse->getTemplate('templatename'));
	}
}
