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

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Calculate the words frequency.
 *
 * Class FrequencyCalculator
 */
class FrequencyCalculator implements CalculatorInterface
{
    /**
     * @var string
     */
    protected $string;

    /**
     * @var DataTransformerInterface
     */
    private $dataTransformer;

    /**
     * FrequencyCalculator constructor.
     *
     * @param DataTransformerInterface $dataTransformer
     */
    public function __construct(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $posts)
    {
        $this->setString($this->dataTransformer->reverseTransform($posts));

        return $this;
    }

    /**
     * @param string $string
     *
     * @return $this
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {
        return array_count_values(str_word_count($this->getString(), 1));
    }
}
