<?php
class Jaded_Router_Route_DynamicTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider dataProvider_badConstructor
	 */
	public function testConstruct_ControllerNotGiven_ThrowsException($sRoute, $aOptions)
	{
		$this->setExpectedException('Jaded_Router_Exception');
		new Jaded_Router_Route_Dynamic($sRoute, $aOptions);
	}

	public function dataProvider_badConstructor()
	{
		// route, params
		return array(
			array('/badroute', array()),
			array('/badroute', array('notcontroller'=>123)),
			array('/:controllernot', array()),
			array('/:controllernot/static', array()),
			array('/base/some:controller/', array()),
		);
	}

	/**
	 * @dataProvider dataProvider_goodConstructor
	 */
	public function testConstruct_ControllerGivenInRoute_DoesNotThrowException($sRoute, $aOptions)
	{
		try {
			new Jaded_Router_Route_Dynamic($sRoute, $aOptions);
		} catch (Jaded_Router_Exception $e) {
			$this->fail('controller given in route');
		}
	}

	public function dataProvider_goodConstructor()
	{
		// route, params
		return array(
			array('/:controller', array()),
			array('/:controller/', array()),
			array('/base/:controller', array()),
			array('/base/:controller/else', array()),
		);
	}

	/**
	 * @dataProvider dataProvider_routes
	 */
	public function testDynamicRoute($sRoute, $aOptions, $sUri, $aExpected)
	{
		$oRoute = new Jaded_Router_Route_Dynamic($sRoute, $aOptions);
		$aResult = $oRoute->map($sUri);
		$this->assertEquals($aExpected, $aResult);
	}

	public function dataProvider_routes()
	{
		// route, params, uri, expected
		return array(
			// No match
			array('/match', array('controller'=>'MatchController'),
				'/nomatch',	null),

			// Basic match
			array('/match', array('controller'=>'MatchController'),
				'/match', array('controller'=>'MatchController')),
			array('/match', array('controller'=>'MatchController'),
				'/match/', array('controller'=>'MatchController')),

			// Match with a required parameter
			array('/match/:matchid', array('controller'=>'MatchMeController'),
				'/match/123', array('controller'=>'MatchMeController', 'matchid'=>'123')),
			array('/match/:matchid', array('controller'=>'MatchMeController'),
				'/match', null),

			// Match with a default parameter
			array('/match/:matchid', array('controller'=>'MatchMeController', 'matchid' => 123),
				'/match', array('controller'=>'MatchMeController', 'matchid'=>'123')),
			array('/match/:matchid', array('controller'=>'MatchMeController', 'matchid' => 123),
				'/match/', array('controller'=>'MatchMeController', 'matchid'=>'123')),
			array('/match/:matchid', array('controller'=>'MatchMeController', 'matchid' => 123),
				'/match/456', array('controller'=>'MatchMeController', 'matchid'=>'456')),

			// Multiple parameters
			array('/match/:matchid/:subid', array('controller'=>'MatchMeController', 'matchid' => 123),
				'/match/456/789', array('controller'=>'MatchMeController', 'matchid'=>'456', 'subid'=>'789')),
			array('/match/:matchid/:subid', array('controller'=>'MatchMeController', 'subid' => 123),
				'/match/456/789', array('controller'=>'MatchMeController', 'matchid'=>'456', 'subid'=>'789')),
			array('/match/:matchid/:subid', array('controller'=>'MatchMeController', 'subid' => 123),
				'/match/456', array('controller'=>'MatchMeController', 'matchid'=>'456', 'subid'=>'123')),
			array('/match/:matchid/:subid', array('controller'=>'MatchMeController', 'matchid'=>456, 'subid' => 123),
				'/match', array('controller'=>'MatchMeController', 'matchid'=>'456', 'subid'=>'123')),

			// Default followed by static
			array('/match/:matchid/static', array('controller'=>'MatchMeController'),
				'/match/456/static', array('controller'=>'MatchMeController', 'matchid'=>'456')),
			array('/match/:matchid/static', array('controller'=>'MatchMeController'),
				'/match/static', null),
			array('/match/:matchid/static/:subid', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/456/static/123', array('controller'=>'MatchMeController', 'matchid'=>'456', 'subid'=>'123')),
			array('/match/:matchid/static/:subid', array('controller'=>'MatchMeController'),
				'/match/456/static', null),

			// Controller override
			array('/:controller/:matchid', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/123', array('controller'=>'match', 'matchid'=>'123')),

			// Wildcard match
			array('/*', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/123', array('controller'=>'MatchMeController', 'matchid'=>'456')),
			array('/*/:matchid', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/123', array('controller'=>'MatchMeController', 'matchid'=>'123')),
			array('/*/static/*/:matchid', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/123', null),
			array('/*/static/*/:matchid', array('controller'=>'MatchMeController', 'matchid'=>456),
				'/match/static/path/123', array('controller'=>'MatchMeController', 'matchid'=>'123')),
			array('/*/static/*/:matchid', array('controller'=>'MatchMeController'),
				'/match/static/path', null),
		);
	}
}
?>