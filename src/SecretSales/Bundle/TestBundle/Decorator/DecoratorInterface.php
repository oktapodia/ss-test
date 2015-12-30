<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Decorator;

/**
 * Interface DecoratorInterface.
 */
interface DecoratorInterface
{
    /**
     * Decorate the $value element.
     *
     * @param string|array $value
     *
     * @return string|array
     */
    public function decorate($value);
}
