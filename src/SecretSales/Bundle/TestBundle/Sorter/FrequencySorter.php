<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Sorter;

use SecretSales\Bundle\TestBundle\Comparator\ComparatorInterface;

/**
 * Sort an array by frequency
 *
 * Class FrequencySorter
 */
class FrequencySorter
{
    /**
     * @var ComparatorInterface
     */
    private $comparator;

    /**
     * FrequencySorter constructor.
     *
     * @param ComparatorInterface $comparator
     */
    public function __construct(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    public function sort(array $items)
    {
        $callback = array($this->comparator, 'compare');
        uasort($items, $callback);

        return $items;
    }
}
