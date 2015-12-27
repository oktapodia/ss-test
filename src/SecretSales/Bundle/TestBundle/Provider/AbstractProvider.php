<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Provider;

/**
 * Class AbstractProvider
 */
abstract class AbstractProvider implements ProviderInterface
{
    const NAME = 'default';

    /**
     * {@inheritdoc}
     */
    abstract public function checkCredentials();

    /**
     * {@inheritdoc}
     */
    abstract public function checkAccount($accountName);

    /**
     * {@inheritdoc}
     */
    abstract public function getNLatestPosts($number, $accountName);

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return static::NAME;
    }
}
