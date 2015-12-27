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

use SecretSales\Bundle\TestBundle\Exception\AccountNameNotFoundException;
use SecretSales\Bundle\TestBundle\Exception\BadAuthenticationException;

/**
 * Interface ProviderInterface
 */
interface ProviderInterface
{

    /**
     * @param int    $number
     * @param string $accountName
     *
     * @return null|array
     */
    public function getNLatestPosts($number, $accountName);

    /**
     * @return bool
     *
     * @throws BadAuthenticationException
     */
    public function checkCredentials();

    /**
     * @param string $accountName
     *
     * @return bool
     *
     * @throws AccountNameNotFoundException
     */
    public function checkAccount($accountName);

    /**
     * @return string
     */
    public function getName();
}
