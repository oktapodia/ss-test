<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Sorter;

/**
 * Interface SorterInterface.
 */
interface SorterInterface
{
    /**
     * Execute a sorting function on the $items array.
     *
     * @param array $items
     *
     * @return array
     */
    public function sort(array $items);
}
