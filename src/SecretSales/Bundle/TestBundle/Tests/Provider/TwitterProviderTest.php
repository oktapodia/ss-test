<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\TestsProvider;

use Abraham\TwitterOAuth\TwitterOAuth;
use SecretSales\Bundle\TestBundle\Formatter\TwitterResponseFormatter;
use SecretSales\Bundle\TestBundle\Provider\TwitterProvider;
use SecretSales\Bundle\TestBundle\Tests\Fixtures\TwitterResponseFixtures;
use SecretSales\Bundle\TestBundle\Tests\Helpers\BasePHPUnitTestCase;

/**
 * Class TwitterProvider.
 */
class TwitterProviderTest extends BasePHPUnitTestCase
{
    /**
     * @var TwitterOAuth|\Phake_IMock
     */
    private $twitterOauth;

    /**
     * @var TwitterProvider
     */
    private $twitterProvider;
    /**
     * @var TwitterResponseFixtures
     */
    private $fixtures;

    protected function setUp()
    {
        $this->twitterOauth = \Phake::mock(TwitterOAuth::class);
        $formatter = new TwitterResponseFormatter();
        $this->fixtures = new TwitterResponseFixtures();

        \Phake::when($this->twitterOauth)->get('users/show', \Phake::ignoreRemaining())->thenReturn($this->fixtures->getValidFixture());
        \Phake::when($this->twitterOauth)->get('account/verify_credentials')->thenReturn($this->fixtures->getValidFixture());

        $this->twitterProvider = new TwitterProvider($this->twitterOauth, $formatter);
    }

    /**
     * @param int   $postsNumber
     * @param array $expected
     *
     * @dataProvider getProvider
     */
    public function testGetNLatestPosts($postsNumber, array $expected)
    {
        $data = $this->fixtures->getFixtureArray($postsNumber);

        \Phake::when($this->twitterOauth)->get('statuses/user_timeline', \Phake::ignoreRemaining())->thenReturn($data);

        $result = $this->twitterProvider->getNLatestPosts($postsNumber, 'test');

        static::assertEquals($expected, $result);
    }

    /**
     * Test checkAccount method.
     */
    public function testCheckAccount()
    {
        $result = $this->twitterProvider->checkAccount('test');

        static::assertTrue($result);
    }

    /**
     * Test checkAccount method with bad account name.
     *
     * @expectedException SecretSales\Bundle\TestBundle\Exception\AccountNameNotFoundException
     * @expectedExceptionMessage Wrong account name ! Please verify if the account name "testBadAccountName" exist
     */
    public function testCheckAccountWithBadAccountName()
    {
        $fixtures = new TwitterResponseFixtures();

        \Phake::when($this->twitterOauth)->get('users/show', \Phake::ignoreRemaining())->thenReturn($fixtures->getFixtureErrorObject());
        $this->twitterProvider->checkAccount('testBadAccountName');
    }

    /**
     * Test checkCredentials method.
     */
    public function testCheckCredentials()
    {
        $result = $this->twitterProvider->checkCredentials();

        static::assertTrue($result);
    }

    /**
     * Test extractPosts method.
     *
     * @param int   $postsNumber
     * @param array $expected
     *
     * @dataProvider getProvider
     */
    public function testExtractPosts($postsNumber, array $expected)
    {
        $result = $this->invokeMethod($this->twitterProvider, 'extractPosts', array($this->fixtures->getFixtureArray($postsNumber)));

        static::assertEquals($expected, $result);
    }

    /**
     * Test parseErrors method.
     */
    public function testparseErrors()
    {
        $result = $this->invokeMethod($this->twitterProvider, 'parseErrors', array($this->fixtures->getFixtureItemWithErrorArray()));

        static::assertEquals(array(
                'An error occurred',
                'A second error occurred',
            ), $result);
    }

    /**
     * Test parseErrors method with inline argument.
     */
    public function testparseErrorsInline()
    {
        $result = $this->invokeMethod($this->twitterProvider, 'parseErrors', array($this->fixtures->getFixtureItemWithErrorArray(), true));

        static::assertEquals('An error occurred, A second error occurred', $result);
    }

    /**
     * Test parseErrors method with pipe delimiter.
     */
    public function testparseErrorsWithPipeDelimiter()
    {
        $result = $this->invokeMethod($this->twitterProvider, 'parseErrors', array($this->fixtures->getFixtureItemWithErrorArray(), true, '|'));

        static::assertEquals('An error occurred|A second error occurred', $result);
    }

    /**
     * Test checkCredentials method with bad credentials.
     *
     * @expectedException SecretSales\Bundle\TestBundle\Exception\BadAuthenticationException
     * @expectedExceptionMessage An error occurred during the authentication : An error occurred, A second error occurred
     */
    public function testCheckCredentialsWithBadCredentials()
    {
        \Phake::when($this->twitterOauth)->get('account/verify_credentials')->thenReturn($this->fixtures->getFixtureErrorObject());
        $this->twitterProvider->checkCredentials();
    }

    /**
     * @return array
     */
    public function getProvider()
    {
        $fixtures = new TwitterResponseFixtures();

        return array(
            array(
                'postsNumber' => 1,
                'expected' => $fixtures->getFixtureExpectedArray(1),
            ),
            array(
                'postsNumber' => 5,
                'expected' => $fixtures->getFixtureExpectedArray(5),
            ),
            array(
                'postsNumber' => 0,
                'expected' => $fixtures->getFixtureExpectedArray(0),
            ),
        );
    }
}
