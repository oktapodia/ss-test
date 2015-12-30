<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Calculator;

/**
 * Interface CalculatorInterface.
 */
interface CalculatorInterface
{
    /**
     * Initialize the calculator with an array to process.
     *
     * @param array $posts
     *
     * @return $this
     */
    public function initialize(array $posts);

    /**
     * Calculate and return the result.
     *
     * @return mixed
     */
    public function calculate();
}
