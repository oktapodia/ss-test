<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transform an array to a string.
 *
 * Class ArrayToStringDataTransformer
 */
class ArrayToStringDataTransformer implements DataTransformerInterface
{
    const DELIMITER = ' ';

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (empty($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException(sprintf('A string is expected, %s given', gettype($value)));
        }

        return explode(self::DELIMITER, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            return;
        }

        if (!is_array($value)) {
            throw new TransformationFailedException(sprintf('An array is expected, %s given', gettype($value)));
        }

        return $this->stringify($value);
    }

    /**
     * @param array $value
     *
     * @return string
     */
    protected function stringify(array $value)
    {
        return implode(self::DELIMITER, $value);
    }
}
