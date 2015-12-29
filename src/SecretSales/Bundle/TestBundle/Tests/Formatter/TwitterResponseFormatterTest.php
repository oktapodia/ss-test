<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Formatter;

use SecretSales\Bundle\TestBundle\Formatter\TwitterResponseFormatter;
use SecretSales\Bundle\TestBundle\Tests\Fixtures\TwitterResponseFixtures;

/**
 * Class TwitterResponseFormatter
 */
class TwitterResponseFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TwitterResponseFormatter
     */
    protected $formatter;

    /**
     * SetUp
     */
    protected function setUp()
    {
        $this->formatter = new TwitterResponseFormatter();
    }

    /**
     * @param array  $array
     * @param string $method
     * @param array  $expected
     *
     * @dataProvider getProvider
     */
    public function testFormat(array $array, $method, $expected)
    {
        $result = $this->formatter->format($array, $method);

        $this->assertSame($expected, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A stdClass object is expected, string given
     */
    public function testFormatWithBadObject()
    {
        $this->formatter->format(array('foo' => 'bar'), 'test');
    }

    /**
     * @param array $array
     *
     * @dataProvider getProvider
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The property "badmethod" does not exist in the stdClass object
     *
     */
    public function testFormatWithBadMethod(array $array)
    {
        $this->formatter->format($array, 'badmethod');
    }
    /**
     * @return array
     */
    public function getProvider()
    {
        $object = new TwitterResponseFixtures();

        return array(
            array(
                'array'    => $object->getFixtureArray(2),
                'method'   => 'text',
                'expected' => $object->getFixtureExpectedArray(2),
            ),
            array(
                'array'    => $object->getFixtureItemWithErrorArray(),
                'method'   => 'message',
                'expected' => $object->getFixtureExpectedItemWithErrorArray(),
            ),
        );
    }
}
