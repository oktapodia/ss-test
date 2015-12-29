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

use Abraham\TwitterOAuth\TwitterOAuth;
use SecretSales\Bundle\TestBundle\Exception\AccountNameNotFoundException;
use SecretSales\Bundle\TestBundle\Exception\BadAuthenticationException;
use SecretSales\Bundle\TestBundle\Formatter\FormatterInterface;

/**
 * Class TwitterProvider
 */
class TwitterProvider extends AbstractProvider
{
    const NAME = 'twitter';
    /**
     * @var TwitterOAuth
     */
    private $twitterOauth;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    /**
     * Constructor
     *
     * @param TwitterOAuth       $twitterOauth
     * @param FormatterInterface $formatter
     */
    public function __construct(TwitterOAuth $twitterOauth, FormatterInterface $formatter)
    {
        $this->twitterOauth = $twitterOauth;
        $this->formatter    = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function getNLatestPosts($postsNumber, $accountName)
    {
        if (!$this->checkAccount($accountName)) {
            return array();
        }

        $posts = $this->twitterOauth->get('statuses/user_timeline', array(
            'screen_name'         => $accountName,
            'exclude_replies'     => 'true',
            'include_rts'         => 'false',
            'contributor_details' => 'false',
            'count'               => $postsNumber,
        ));

        return $this->extractPosts($posts);
    }

    /**
     * {@inheritdoc}
     */
    public function checkAccount($accountName)
    {
        $user = $this->twitterOauth->get('users/show', array(
            'screen_name' => $accountName,
        ));

        if (isset($user->errors)) {
            throw new AccountNameNotFoundException(sprintf('Wrong account name ! Please verify if the account name "%s" exist', $accountName));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials()
    {
        $application = $this->twitterOauth->get("account/verify_credentials");

        if (isset($application->errors)) {
            throw new BadAuthenticationException(sprintf('An error occured during the authentication : %s', implode(', ', $this->parseErrors($application->errors))));
        }

        return true;
    }

    /**
     * @param array $posts
     *
     * @return array
     */
    protected function extractPosts(array $posts)
    {
        return $this->formatter->format($posts, 'text');
    }

    /**
     * @param array  $errors
     * @param bool   $inline
     * @param string $delimiter
     *
     * @return bool
     */
    protected function parseErrors(array $errors, $inline = false, $delimiter = ', ')
    {
        $errorsParsed = $this->formatter->format($errors, 'message');

        if ($inline) {
            $errorsParsed = implode($delimiter, $errorsParsed);
        }

        return $errorsParsed;
    }
}
