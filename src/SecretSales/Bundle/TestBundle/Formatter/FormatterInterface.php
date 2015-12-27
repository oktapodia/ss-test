<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Formatter;

/**
 * Pass a $method on each array elements
 *
 * Interface FormatterInterface
 */
interface FormatterInterface
{
    /**
     * @param array  $array
     * @param string $method
     *
     * @return mixed
     */
    public function format(array $array, $method);
}
