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
 * Reverse (DESC instead of ASC) the sorting of 2 elements.
 *
 * Class ReverseNumericComparator
 */
class ReverseNumericComparator implements ComparatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function compare($a, $b)
    {
        if ($a === $b) {
            return 0;
        }

        return $a > $b ? -1 : 1;
    }
}
