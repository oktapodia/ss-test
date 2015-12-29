<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Decorator;

use SecretSales\Bundle\TestBundle\Decorator\SkipUrlsDecorator;

/**
 * Class SkipUrlsDecoratorTest
 */
class SkipUrlsDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $value
     * @param mixed $expected
     *
     * @dataProvider getProvider
     */
    public function testDecorate($value, $expected)
    {
        $decorator = new SkipUrlsDecorator();
        $result    = $decorator->decorate($value);
        static::assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getProvider()
    {
        $object = new \stdClass();
        $object2 = new \stdClass();
        $object->test = 'I\'m a test object without an url';
        $object2->test = 'I\'m a test object with an url https://secretsales.com/';

        return array(
            array(
                'value'    => 'I\'m a test sentence with an url https://secretsales.com/',
                'expected' => 'I\'m a test sentence with an url',
            ),
            array(
                'value'    => 'I\'m a test sentence without an url',
                'expected' => 'I\'m a test sentence without an url',
            ),
            array(
                'value'    => array(
                    'I\'m a test sentence with an url https://secretsales.com/',
                    'I\'m a second test sentence with an url https://secretsales.com/',
                    'I\'m a third test sentence without an url',
                ),
                'expected' => array(
                    'I\'m a test sentence with an url',
                    'I\'m a second test sentence with an url',
                    'I\'m a third test sentence without an url',
                ),
            ),
            array(
                'value'    => array(
                    'I\'m a test sentence with an url https://secretsales.com/',
                    'I\'m a second test sentence with an url https://secretsales.com/',
                    'I\'m a third test sentence without an url',
                ),
                'expected' => array(
                    'I\'m a test sentence with an url',
                    'I\'m a second test sentence with an url',
                    'I\'m a third test sentence without an url',
                ),
            ),
            array(
                'value'    =>$object,
                'expected' => null,
            ),
        );
    }
}
