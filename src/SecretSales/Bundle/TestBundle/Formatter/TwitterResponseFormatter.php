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
 * Class TwitterResponseFormatter
 */
class TwitterResponseFormatter implements FormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(array $array, $method)
    {
        $items = array_map(function ($item) use ($method) {
            if (!($item instanceof \stdClass)) {
                return null;
            }

            if (!property_exists($item, $method)) {
                return null;
            }

            return $item->$method;
        }, $array);

        return $items;
    }
}
