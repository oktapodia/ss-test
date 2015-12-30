<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Tests\Calculator;

use SecretSales\Bundle\TestBundle\Calculator\FrequencyCalculator;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class FrequencyCalculatorTest.
 */
class FrequencyCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FrequencyCalculator
     */
    protected $frequencyCalculator;

    protected $transformer;

    /**
     * SetUp.
     */
    protected function setUp()
    {
        $this->transformer = \Phake::mock(DataTransformerInterface::class);
        $this->frequencyCalculator = new FrequencyCalculator($this->transformer);
    }

    /**
     * @param string $string
     *
     * @dataProvider getProvider
     */
    public function testInitialize($string)
    {
        \Phake::when($this->transformer)->reverseTransform(\Phake::anyParameters())->thenReturn($string);
        $this->frequencyCalculator->initialize(array($string));

        static::assertSame($string, $this->frequencyCalculator->getString());
    }

    /**
     * @param string $string
     * @param array  $expectedArray
     *
     * @dataProvider getProvider
     */
    public function testCalculate($string, $expectedArray)
    {
        $this->frequencyCalculator->setString($string);
        $result = $this->frequencyCalculator->calculate();

        static::assertSame($expectedArray, $result);
    }

    /**
     * @return array
     */
    public function getProvider()
    {
        return array(
            array(
                'string' => 'I\'m a test string',
                'expectedArray' => array(
                    'I\'m' => 1,
                    'a' => 1,
                    'test' => 1,
                    'string' => 1,
                ),
            ),
            array(
                'string' => 'I\'m a test string with a multiple occurences to run my test',
                'expectedArray' => array(
                    'I\'m' => 1,
                    'a' => 2,
                    'test' => 2,
                    'string' => 1,
                    'with' => 1,
                    'multiple' => 1,
                    'occurences' => 1,
                    'to' => 1,
                    'run' => 1,
                    'my' => 1,
                ),
            ),
        );
    }
}
