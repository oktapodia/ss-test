<?php
/**
 * This file is part of the test project.
 *
 * (c) BRAMILLE Sébastien <sebastien.bramille@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SecretSales\Bundle\TestBundle\Command;

use SecretSales\Bundle\TestBundle\Provider\ProviderContainer;
use SecretSales\Bundle\TestBundle\Provider\ProviderInterface;
use SecretSales\Bundle\TestBundle\Provider\TwitterProvider;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class TwitterKeywordCommand.
 */
class TwitterKeywordCommand extends ContainerAwareCommand
{
    const DEFAULT_TWEETS_NUMBER = 100;
    const ARGUMENT_ACCOUNT_NAME = 'accountName';
    const ARGUMENT_DESCRIPTION_ACCOUNT_NAME = 'Which twitter account name?';
    const OPTION_SKIP_URLS = 'skipUrls';
    const OPTION_TWEETS_NUMBER = 'tweetsNumber';

    /**
     * @var string
     */
    protected $accountName;

    /**
     * @var int
     */
    protected $tweetsNumber;

    /**
     * @var bool
     */
    protected $skipUrls = false;

    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ss:test:twitter_keyword')
            ->setDescription('Output the keywords frequency of a twitter account')
            ->addArgument(
                self::ARGUMENT_ACCOUNT_NAME,
                InputArgument::REQUIRED,
                self::ARGUMENT_DESCRIPTION_ACCOUNT_NAME
            )
            ->addOption(
                self::OPTION_TWEETS_NUMBER,
                null,
                InputOption::VALUE_REQUIRED,
                'If set, the tweets number can be changed',
                self::DEFAULT_TWEETS_NUMBER
            )
            ->addOption(
                self::OPTION_SKIP_URLS,
                null,
                InputOption::VALUE_NONE,
                'If enabled, all urls will be skipped'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $providerContainer = $this->getContainer()->get(ProviderContainer::PROVIDER_CONTAINER);
        $this->provider = $providerContainer->getProvider(TwitterProvider::NAME);

        if (!$this->provider->checkCredentials()) {
            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if ($tweetsNumber = $input->getOption(self::OPTION_TWEETS_NUMBER)) {
            $this->tweetsNumber = (int) $tweetsNumber;
        }

        if ($skipUrls = $input->getOption(self::OPTION_SKIP_URLS)) {
            $this->skipUrls = $skipUrls;
        }

        if (!($accountName = $input->getArgument(self::ARGUMENT_ACCOUNT_NAME))) {
            $helper = $this->getHelper('question');
            $question = new Question(self::ARGUMENT_DESCRIPTION_ACCOUNT_NAME);

            if ($accountName = $helper->ask($input, $output, $question)) {
                $input->setArgument(self::ARGUMENT_ACCOUNT_NAME, $accountName);
            }
        }

        if (!$this->provider->checkAccount($accountName)) {
            return;
        }

        $this->accountName = $accountName;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $posts = $this->provider->getNLatestPosts(100, $this->accountName);
        $postsNumber = count($posts);

        if ($postsNumber < $this->tweetsNumber) {
            $output->writeln(sprintf('<comment>The user "%s" only have %d tweets</comment>', $this->accountName, $postsNumber));
        }

        $output->writeln(sprintf('<comment>%d tweets will be displayed</comment>', $postsNumber));
        $container = $this->getContainer();

        if ($this->skipUrls) {
            $skipUrlsDecorator = $container->get('ss.decorator.skip_urls');
            $posts = $skipUrlsDecorator->decorate($posts);
        }

        $frequencyCalculator = $container->get('ss.calculator.frequency');
        $frequencySorter = $container->get('ss.sorter.frequency');

        $frequencyCalculator->initialize($posts);
        $wordsFrequency = $frequencySorter->sort($frequencyCalculator->calculate());

        $output->writeln(sprintf('<info>%d words</info>', count($wordsFrequency)));
        $this->displayResult($wordsFrequency, $output);
    }

    /**
     * Display the result with the asked formatting.
     *
     * @param array           $data
     * @param OutputInterface $output
     */
    protected function displayResult(array $data, OutputInterface $output)
    {
        foreach ($data as $keyword => $count) {
            $output->writeln(sprintf('%s,%d', $keyword, $count));
        }
    }
}
