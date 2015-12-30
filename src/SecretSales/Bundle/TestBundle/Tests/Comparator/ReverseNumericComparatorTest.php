<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Tests\Comparator;

use SecretSales\Bundle\TestBundle\Comparator\ReverseNumericComparator;

/**
 * Class ReverseNumericComparatorTest.
 */
class ReverseNumericComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getProvider
     *
     * @param array $data
     * @param int   $expected
     */
    public function testCompare($data, $expected)
    {
        $comparator = new ReverseNumericComparator();
        static::assertEquals($expected, $comparator->compare($data['a'], $data['b']));
    }

    /**
     * @return array
     */
    public function getProvider()
    {
        return array(
            array(
                'data' => array(
                    'a' => 1,
                    'b' => 2,
                ),
                'expected' => 1,
            ),
            array(
                'data' => array(
                    'a' => 2,
                    'b' => 1,
                ),
                'expected' => -1,
            ),
            array(
                'data' => array(
                    'a' => 42,
                    'b' => 42,
                ),
                'expected' => 0,
            ),
        );
    }
}
