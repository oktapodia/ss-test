<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\DataTransformer;

/**
 * Class ArrayToStringDataTransformerTest.
 */
class ArrayToStringDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayToStringDataTransformer
     */
    protected $transformer;

    /**
     * SetUp.
     */
    protected function setUp()
    {
        $this->transformer = new ArrayToStringDataTransformer();
    }

    /**
     * @dataProvider getProvider
     *
     * @param array  $array
     * @param string $string
     */
    public function testTransform($array, $string)
    {
        $result = $this->transformer->transform($string);

        static::assertEquals($array, $result);
    }

    /**
     * @dataProvider getProvider
     *
     * @param array  $array
     * @param string $string
     *
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage A string is expected, array given
     */
    public function testTransformWithFailedParameters($array, $string)
    {
        $this->transformer->transform($array);
    }

    /**
     * @dataProvider getProvider
     *
     * @param array  $array
     * @param string $string
     *
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage An array is expected, string given
     */
    public function testReverseTransformWithFailedParameters($array, $string)
    {
        $this->transformer->reverseTransform($string);
    }

    /**
     * @dataProvider getProvider
     *
     * @param array  $array
     * @param string $string
     */
    public function testReverseTransform($array, $string)
    {
        $result = $this->transformer->reverseTransform($array);

        static::assertEquals($string, $result);
    }

    /**
     * @return array
     */
    public function getProvider()
    {
        return array(
            array(
                'array' => array(
                    'I\'m',
                    'a',
                    'test',
                    'sentence',
                ),
                'string' => 'I\'m a test sentence',
            ),
        );
    }
}
