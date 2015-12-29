<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Sorter;

use SecretSales\Bundle\TestBundle\Comparator\ReverseNumericComparator;
use SecretSales\Bundle\TestBundle\Sorter\FrequencySorter;

/**
 * Class FrequencySorterTest
 */
class FrequencySorterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FrequencySorter
     */
    private $frequencySorter;

    /**
     * SetUp
     */
    protected function setUp()
    {
        $comparator            = new ReverseNumericComparator();
        $this->frequencySorter = new FrequencySorter($comparator);
    }

    /**
     * @param array $data
     * @param array $expected
     *
     * @dataProvider getProvider
     */
    public function testSort(array $data, array $expected)
    {
        $result = $this->frequencySorter->sort($data);
        $this->assertEquals($expected, $result);
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
                'expected' => array(
                    'b' => 2,
                    'a' => 1,
                ),
            ),
            array(
                'data' => array(
                    'a' => 2,
                    'b' => 1,
                ),
                'expected' => array(
                    'b' => 1,
                    'a' => 2,
                ),
            ),
            array(
                'data' => array(
                    'a' => 42,
                    'b' => 42,
                ),
                'expected' => array(
                    'a' => 42,
                    'b' => 42,
                ),
            ),
        );
    }
}
