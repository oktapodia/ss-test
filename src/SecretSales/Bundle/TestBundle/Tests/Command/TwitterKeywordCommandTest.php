<?php
/**
 * This file is part of the test project
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretSales\Bundle\TestBundle\Tests\Comand;

use Abraham\TwitterOAuth\TwitterOAuth;
use SecretSales\Bundle\TestBundle\Command\TwitterKeywordCommand;
use SecretSales\Bundle\TestBundle\Tests\Fixtures\TwitterResponseFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class TwitterKeywordCommand
 */
class TwitterKeywordCommandTest extends WebTestCase
{
    /**
     * @var TwitterOAuth
     */
    protected $twitterOauth;
    /**
     * @var TwitterKeywordCommand
     */
    protected $command;
    /**
     * @var array
     */
    protected $expectedValue;
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var TwitterResponseFixtures
     */
    protected $fixtures;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        //Override the twitterOauth service
        $this->fixtures      = new TwitterResponseFixtures();
        $this->twitterOauth  = \Phake::mock(TwitterOAuth::class);

        $this->setTweetsNumber(100);
        static::$kernel->getContainer()->set('ss.oauth.twitter', $this->twitterOauth);

        $this->command = new TwitterKeywordCommand();

        $application = new Application(static::$kernel);
        $this->command->setContainer(static::$kernel->getContainer());
        $this->command->setApplication($application);

        $this->parameters = array('account_name' => 'test');
    }

    public function testExecuteWithAccountNameInCommand()
    {
        $this->setTweetsNumber(100);
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array('command' => $this->command->getName(), TwitterKeywordCommand::ARGUMENT_ACCOUNT_NAME => $this->parameters['account_name']));

        $this->runBaseAssertions($commandTester);
        $this->runBaseFrequencyAssertion($commandTester);
    }

    public function testExecuteWithAccountNameInCommandAndOneTweet()
    {
        $tweetsNumber = 1;
        $this->setTweetsNumber($tweetsNumber);
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command'                                        => $this->command->getName(),
            TwitterKeywordCommand::ARGUMENT_ACCOUNT_NAME     => $this->parameters['account_name'],
            '--'.TwitterKeywordCommand::OPTION_TWEETS_NUMBER => $tweetsNumber,
        ));

        $this->runBaseAssertions($commandTester);
        $this->assertRegExp('/a,2
test,2
run,1
to,1
my,1
secretsales,1
fr,1
url,1
http,1
and,1
with,1
string,1
multiple,1
occurencies,1
I\'m,1
an,1/', $commandTester->getDisplay());
    }

    public function testExecuteWithoutAccountName()
    {
        $this->setTweetsNumber(100);
        $dialog = $this->command->getHelper('question');
        $dialog->setInputStream($this->getInputStream($this->parameters['account_name']."\n"));

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array('command' => $this->command->getName()));

        $this->assertRegExp(sprintf('/Which twitter account name?/', $this->parameters['account_name'], count($this->expectedValue)), $commandTester->getDisplay());
        $this->runBaseAssertions($commandTester);
        $this->runBaseFrequencyAssertion($commandTester);
    }

    public function testExecuteWithAccountNameAndSkipUrlsOption()
    {
        $this->expectedValue = $this->fixtures->getFixtureArray(10);
        \Phake::when($this->twitterOauth)->get(\Phake::anyParameters())->thenReturn($this->expectedValue);

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(array(
            'command'                                    => $this->command->getName(),
            TwitterKeywordCommand::ARGUMENT_ACCOUNT_NAME => $this->parameters['account_name'],
            '--'.TwitterKeywordCommand::OPTION_SKIP_URLS,
        ));


        $this->runBaseAssertions($commandTester);
        $this->assertRegExp('
        /a,20
test,20
run,10
to,10
my,10
secretsales,10
fr,10
url,10
http,10
and,10
with,10
string,10
multiple,10
occurencies,10
I\'m,10
an,10/', $commandTester->getDisplay());

    }

    protected function runBaseAssertions(CommandTester $commandTester)
    {
        $this->assertRegExp(sprintf('/%d tweets will be displayed/', count($this->expectedValue)), $commandTester->getDisplay());
        $this->assertRegExp(sprintf('/([0-9]+) words/', $this->parameters['account_name'], count($this->expectedValue)), $commandTester->getDisplay());
    }

    protected function runBaseFrequencyAssertion(CommandTester $commandTester)
    {
        $this->assertRegExp('/a,200
test,200
run,100
to,100
my,100
secretsales,100
fr,100
url,100
http,100
and,100
with,100
string,100
multiple,100
occurencies,100
I\'m,100
an,100/', $commandTester->getDisplay());
    }

    protected function setTweetsNumber($tweetsNumber)
    {
        $this->expectedValue = $this->fixtures->getFixtureArray($tweetsNumber);
        \Phake::when($this->twitterOauth)->get(\Phake::anyParameters())->thenReturn($this->expectedValue);
    }

    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fputs($stream, $input);
        rewind($stream);

        return $stream;
    }
}
