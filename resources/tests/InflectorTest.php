<?php

use Fuel\Util\Inflector;

class InflectorTest extends PHPUnit_Framework_TestCase
{

	public function ordinalizeProvider()
	{
		return array(
			array(1, 'st'),
			array(21, 'st'),
			array(2, 'nd'),
			array(22, 'nd'),
			array(3, 'rd'),
			array(23, 'rd'),
			array(4, 'th'),
			array(24, 'th'),
			array(111, 'th'),
			array(112, 'th'),
			array(113, 'th'),
		);
	}

	/**
	 * Test for Inflector::ordinalize()
	 *
	 * @test
	 * @dataProvider ordinalizeProvider
	 */
	public function testOrdinalize($number, $ending)
	{
		$this->assertEquals($number.$ending, Inflector::ordinalize($number));
	}

	/**
	 * Test for Inflector::ordinalize()
	 *
	 * @test
	 */
	public function testOrdinalizeOfString()
	{
		$this->assertEquals('Foo', Inflector::ordinalize('Foo'));
	}

	public function quantifyProvider()
	{
		return array(
			array(1,	'mouse',	null,	'1 mouse'),
			array('00',	'mouse',	null,	'no mice'),
			array(2,	'goose',	null,	'2 geese'),
			array(4,	'deer',		null,	'4 deer'),
			array(5,	'deer',		'deers','5 deers'),
		);
	}

	/**
	* Test for Inflector::quantify
	*
	* @test
	* @dataProvider quantifyProvider
	*/
	public function testQuantify($number, $word, $plword, $expected)
	{
		if($plword === null)
		{
			$p = Inflector::quantify($number,$word);
		}
		else
		{
			$p = Inflector::quantify($number,$word,$plword);
		}
		$this->assertEquals($expected, $p);
	}

	public function conditionalPluralizeProvider()
	{
		return array(
			array('mouse',	0,	null,	'mice'),
			array('mouse',	1,	null,	'mouse'),
			array('mouse',	2,	null,	'mice'),
			array('deer',	1,	null,	'deer'),
			array('deer',	2,	null,	'deer'),
			array('deer',	2,	'deers','deers'),
		);
	}

	/**
	* Test for Inflector::quantify
	*
	* @test
	* @dataProvider quantifyProvider
	*/
	public function testConditionalPluralize($word, $number, $plword, $expected)
	{
		if($plword === null)
		{
			$p = Inflector::conditionalPluralize($word,$number);
		}
		else
		{
			$p = Inflector::conditionalPluralize($word,$number,$plword);
		}
		$this->assertEquals($expected, $p);
	}

	/**
	 * Test for Inflector::ascii()
	 *
	 * @test
	 */
	public function testAscii()
	{
		$output = Inflector::ascii('Inglés');
		$expected = "Ingles";
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::camelize()
	 *
	 * @test
	 */
	public function testCamelize()
	{
		$output = Inflector::camelize('apples_and_oranges');
		$expected = 'ApplesAndOranges';
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::classify()
	 *
	 * @test
	 */
	public function testClassify()
	{
		$output = Inflector::classify('fuel_users');
		$expected = 'Fuel_User';
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::denamespace()
	 *
	 * @test
	 */
	public function testDenamespace()
	{
		$this->assertEquals(Inflector::denamespace('Fuel\\SomeClass'), 'SomeClass');
		$this->assertEquals(Inflector::denamespace('\\SomeClass'), 'SomeClass');
		$this->assertEquals(Inflector::denamespace('SomeClass'), 'SomeClass');
		$this->assertEquals(Inflector::denamespace('SomeClass\\'), 'SomeClass');
	}

	/**
	 * Test for Inflector::foreignKey()
	 *
	 * @test
	 */
	public function testForeignKey()
	{
		$output = Inflector::foreignKey('Inflector');
		$expected = 'inflector_id';
		$this->assertEquals($expected, $output);

		$output = Inflector::foreignKey('Inflector', false);
		$expected = 'inflectorid';
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::friendly_title()
	 *
	 * @test
	 */
	public function testFriendlyTitle()
	{
		$output = Inflector::friendlyTitle('Fuel is a community driven PHP 5 web framework.', '-', true);
		$expected = 'fuel-is-a-community-driven-php-5-web-framework';
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::humanize()
	 *
	 * @test
	 */
	public function testHumanize()
	{
		$output = Inflector::humanize('apples_and_oranges');
		$expected = 'Apples and oranges';
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::is_countable()
	 *
	 * @test
	 */
	public function testIsCountable()
	{
		$output = Inflector::isCountable('fish');
		$this->assertFalse($output);

		$output = Inflector::isCountable('apple');
		$this->assertTrue($output);
	}

	/**
	 * Test for Inflector::pluralize()
	 *
	 * @test
	 */
	public function testPluralize()
	{
		$output = Inflector::pluralize('apple');
		$expected = "apples";
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::pluralize()
	 *
	 * @test
	 */
	public function testPluralizeUncountable()
	{
		$this->assertEquals('equipment', Inflector::pluralize('equipment'));
	}

	/**
	 * Test for Inflector::singularize()
	 *
	 * @test
	 */
	public function testSingularize()
	{
		$output = Inflector::singularize('apples');
		$expected = "apple";
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::singularize()
	 *
	 * @test
	 */
	public function testSingularizeUncountable()
	{
		$this->assertEquals('equipment', Inflector::singularize('equipment'));
	}

	public function tableizeProvider()
	{
		return array(
			array('\\Model\\User', 'users'),
			array('\\Model\\Person', 'people'),
			array('\\Model\\Mouse', 'mice'),
			array('\\Model\\Ox', 'oxen'),
			array('\\Model\\Matrix', 'matrices'),
			array('Model_User', 'model_users'),
		);
	}

	/**
	 * Test for Inflector::tableize()
	 *
	 * @test
	 * @dataProvider tableizeProvider
	 */
	public function testTableize($class, $table)
	{
		$this->assertEquals(Inflector::tableize($class), $table);
	}

	public function getNamespaceProvider()
	{
		return array(
			array('\\Model\\User', 'Model\\'),
			array('\\Fuel\\Core\\Inflector', 'Fuel\\Core\\'),
			array('Model_User', ''),
		);
	}

	/**
	 * Test for Inflector::get_namespace()
	 *
	 * @test
	 * @dataProvider getNamespaceProvider
	 */
	public function testGetNamespace($class, $namespace)
	{
		$this->assertEquals(Inflector::getNamespace($class), $namespace);
	}

	/**
	 * Test for Inflector::underscore()
	 *
	 * @test
	 */
	public function testUnderscore()
	{
		$output = Inflector::underscore('ApplesAndOranges');
		$expected = "apples_and_oranges";
		$this->assertEquals($expected, $output);
	}

	/**
	 * Test for Inflector::wordsToUpper()
	 *
	 * @test
	 */
	public function testWordsToUpper()
	{
		$output = Inflector::wordsToUpper('apples_and_oranges');
		$expected = 'Apples_And_Oranges';
		$this->assertEquals($expected, $output);
	}
}
