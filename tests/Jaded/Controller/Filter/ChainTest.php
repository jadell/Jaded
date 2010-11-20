 <?php
class Jaded_Controller_Filter_ChainTest extends PHPUnit_Framework_TestCase
{
	public function testChainFilter_PassesRequestThroughEachFilterInChain()
	{
		$oRequest = new Jaded_Request();
		$oResponse = new Jaded_Response();
		$oController = $this->getMock('Jaded_Controller', array('preProcess','process','postProcess'));

		$oChain = new ControllerFilterChainTester($oController);
		$oChain->dispatch($oRequest, $oResponse);

		$this->assertEquals('set by filter 1', $oRequest->getParam('Param1'));
		$this->assertEquals('set by filter 2', $oRequest->getParam('Param2'));
	}
}
