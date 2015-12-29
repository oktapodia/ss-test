SS test
=======

[![Circle CI](https://circleci.com/gh/oktapodia/ss-test/tree/master.svg?style=svg)](https://circleci.com/gh/oktapodia/ss-test/tree/master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/78d4863e-3896-4273-a8c3-2c28a9d798b0/mini.png)](https://insight.sensiolabs.com/projects/78d4863e-3896-4273-a8c3-2c28a9d798b0) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/oktapodia/ss-test/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/oktapodia/ss-test/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/oktapodia/ss-test/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/oktapodia/ss-test/?branch=master)

To use the keyword frequency command, please copy `app/config/parameters.yml.dist` to `app/config/parameters.yml` and configure it with your twitter application credentials.

Run this command with : `app/console ss:twitter:keyword:frequency [options] [--] <accountName>`

OPTIONS
-------
    --tweetsNumber=TWEETSNUMBER  If set, the tweets number can be changed [default: 100]
    --skipUrls                   If enabled, all urls will be skipped
