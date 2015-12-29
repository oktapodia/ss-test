<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Decorator;

/**
 * Remove all the URLs elements
 *
 * Class SkipUrlsDecorator
 */
class SkipUrlsDecorator implements DecoratorInterface
{
    const REGEX_URL = '/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'\".,<>?«»“”‘’]))/';
    /**
     * {@inheritdoc}
     */
    public function decorate($value)
    {
        if (is_array($value)) {
            return array_map(array(self::class, 'removeUrls'), $value);
        }

        if (is_string($value)) {
            return $this->removeUrls($value);
        }

        return null;
    }

    /**
     * @param string $string
     *
     * @return null|string
     */
    protected function removeUrls($string)
    {
        return trim(preg_replace(self::REGEX_URL, '', $string));
    }
}
