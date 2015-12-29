<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Helpers;

use ReflectionClass;

/**
 * Class BasePHPUnitTestCase
 */
class BasePHPUnitTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param object $class
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     */
    protected static function invokeMethod($class, $name, $parameters)
    {
        $reflectionClass = new ReflectionClass($class);
        $method          = $reflectionClass->getMethod($name);
        $method->setAccessible(true);

        return $method->invokeArgs($class, $parameters);
    }
}
