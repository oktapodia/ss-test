<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AccountNameNotFoundException
 */
class AccountNameNotFoundException extends NotFoundHttpException
{
    /**
     * AccountNameNotFoundException constructor.
     *
     * @param null            $message
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}
