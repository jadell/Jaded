<?php
class Jaded_Model_StoreTest extends PHPUnit_Framework_TestCase
{
	public function testSingleton_ReturnsRequestedModelStore()
	{
		$oDef = Jaded_Model_Store::instance('ModelStoreTester');
		$this->assertType('ModelStoreTester', $oDef);
	}

	public function testSingleton_CalledMoreThanOnce_ReturnsSingleton()
	{
		$oDef = Jaded_Model_Store::instance('ModelStoreTester');
		$oDef2 = Jaded_Model_Store::instance('ModelStoreTester');
		$this->assertSame($oDef, $oDef2);
	}

	public function testSingleton_CalledWithNonStoreClass_ThrowsException()
	{
		$this->setExpectedException('Jaded_Model_Exception');
		$oDef = Jaded_Model_Store::instance(__CLASS__);
	}
}
?>