<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Comparator;

/**
 * Interface ComparatorInterface.
 */
interface ComparatorInterface
{
    /**
     * Compare 2 elements.
     *
     * @param mixed $a
     * @param mixed $b
     *
     * @return int -1 if $a should precede $b
     *             1 if $b should precede $a
     *             0 if considered equal
     */
    public function compare($a, $b);
}
