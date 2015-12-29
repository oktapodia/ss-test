<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Fixtures;

/**
 * Class TwitterResponseFixtures
 */
class TwitterResponseFixtures
{
    /**
     * @var \stdClass
     */
    protected $item;

    /**
     * @var \stdClass
     */
    protected $itemWithError;

    /**
     * @var \stdClass
     */
    protected $itemWithError2;

    /**
     * TwitterResponseFixture constructor.
     */
    public function __construct()
    {
        $this->item = new \stdClass();
        $this->item->text = 'I\'m a test string with a multiple occurences and an url to run my test http://secretsales.fr';
        $this->itemWithError = new \stdClass();
        $this->itemWithError->message = 'An error occurred';
        $this->itemWithError2 = new \stdClass();
        $this->itemWithError2->message = 'A second error occurred';
    }

    /**
     * @return \stdClass
     */
    public function getValidFixture()
    {
        return $this->item;
    }

    /**
     * @return \stdClass
     */
    public function getValidExpectedFixture()
    {
        return $this->item->text;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getFixtureArray($limit = 100)
    {
        $items = array();
        for ($i=0; $i < $limit; $i++) {
            array_push($items, $this->getValidFixture());
        }

        return $items;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getFixtureExpectedArray($limit = 100)
    {
        $items = array();
        for ($i=0; $i < $limit; $i++) {
            array_push($items, $this->getValidExpectedFixture());
        }

        return $items;
    }

    /**
     * @return \stdClass
     */
    public function getFixtureItemWithError()
    {
        return $this->itemWithError;
    }

    /**
     * @return array
     */
    public function getFixtureItemWithErrorArray()
    {
        return array($this->itemWithError, $this->itemWithError2);
    }

    /**
     * @return array
     */
    public function getFixtureExpectedItemWithErrorArray()
    {
        return array($this->itemWithError->message, $this->itemWithError2->message);
    }

    /**
     * @return \stdClass
     */
    public function getFixtureErrorObject()
    {
        $object = new \stdClass();
        $object->errors = $this->getFixtureItemWithErrorArray();

        return $object;
    }
}
