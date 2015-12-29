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
                throw new \InvalidArgumentException(sprintf('A stdClass object is expected, %s given', gettype($item)));
            }

            if (!property_exists($item, $method)) {
                throw new \InvalidArgumentException(sprintf('The property "%s" does not exist in the stdClass object', $method));
            }

            return $item->$method;
        }, $array);

        return $items;
    }
}
