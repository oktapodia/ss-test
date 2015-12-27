SS test
=======

To use the keyword frequency command, please copy `app/config/parameters.yml.dist` to `app/config/parameters.yml` and configure it with your twitter application credentials.

Run this command with : `app/console ss:twitter:keyword:frequency [options] [--] <accountName>`

OPTIONS
-------
    --tweetsNumber=TWEETSNUMBER  If set, the tweets number can be changed [default: 100]
    --skipUrls                   If enabled, all urls will be skipped
