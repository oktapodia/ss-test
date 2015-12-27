<?php
/**
 * This file is part of the test project
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
 * Class TwitterKeywordCommand
 */
class TwitterKeywordCommand extends ContainerAwareCommand
{
    const DEFAULT_TWEETS_NUMBER = 100;

    const ARGUMENT_ACCOUNT_NAME             = 'accountName';
    const ARGUMENT_DESCRIPTION_ACCOUNT_NAME = 'Which twitter account name?';
    const OPTION_TWEETS_NUMBER              = 'tweetsNumber';

    /**
     * @var string
     */
    protected $accountName;

    /**
     * @var int
     */
    protected $tweetsNumber;

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
            ->setName('ss:twitter:keyword:frequency')
            ->setDescription('Output the keywords frequency of a twitter account')
            ->addArgument(
                self::ARGUMENT_ACCOUNT_NAME,
                InputArgument::REQUIRED,
                self::ARGUMENT_DESCRIPTION_ACCOUNT_NAME
            )
            ->addOption(
                self::OPTION_TWEETS_NUMBER,
                null,
                InputOption::VALUE_OPTIONAL,
                'If set, the tweets number can be changed',
                self::DEFAULT_TWEETS_NUMBER
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $providerContainer = $this->getContainer()->get(ProviderContainer::PROVIDER_CONTAINER);
        $this->provider    = $providerContainer->getProvider(TwitterProvider::NAME);

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

        if (!($accountName = $input->getArgument(self::ARGUMENT_ACCOUNT_NAME))) {
            $helper   = $this->getHelper('question');
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
        $posts       = $this->provider->getNLatestPosts(100, $this->accountName);
        $postsNumber = count($posts);

        if ($postsNumber < $this->tweetsNumber) {
            $output->writeln(sprintf('<comment>The user "%s" just have %d tweets. (%d expected)</comment>', $this->accountName, $postsNumber, $this->tweetsNumber));
        }

        $container           = $this->getContainer();
        $frequencyCalculator = $container->get('ss.calculator.frequency');
        $frequencySorter     = $container->get('ss.sorter.frequency');

        $frequencyCalculator->initialize($posts);
        $wordsFrequency      = $frequencySorter->sort($frequencyCalculator->calculate());

        $output->writeln(sprintf('<info>%d words</info>', count($wordsFrequency)));
        $this->displayResult($wordsFrequency, $output);
    }

    /**
     * Display the result with the asked formating
     *
     * @param array           $datas
     * @param OutputInterface $output
     */
    protected function displayResult(array $datas, OutputInterface $output)
    {
        foreach ($datas as $keyword => $count) {
            $output->writeln(sprintf('%s,%d', $keyword, $count));
        }
    }
}
