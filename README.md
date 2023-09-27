![BEON LOGO](https://beon.studio/blog/wp-content/themes/twentybeon/app/images/beon-purple.png)

# PHP Live Coding Challenge

Before joining the live coding challenge, you should have set up the local environment for the application.

## Getting started

Requirements:
- Docker (with compose support)

After installing docker run: `cat getting_started.sh | bash` from your CLI.

We recommend that you also read the code so that you are not caught off guard.

## What does the live coding looks like?

The live coding session will be more like a pair programming exercise, we will request you to implement a feature, solve bugs or give code advice. You will be able to use Google and any documentation that can help you. Instructions will be provided in the live coding session.

## Extra details

To add the phone validation feature you should use the following API: https://numverify.com/documentation considering US numbers.

## Key commands:

* Run all tests: `./vendor/bin/sail test`
* Proxy phpunit: `./vendor/bin/sail phpunit tests/Unit/ExampleTest.php`
* Proxy artisan: `./vendor/bin/sail artisan [extra args]`
* Proxy debug to artisan: `./vendor/bin/sail debug [extra args]`
* Proxy composer: `./vendor/bin/sail composer [extra args]`
* Shutdown containers: `./vendor/bin/sail stop`
* Shutdown and remove containers: `./vendor/bin/sail down`

## Having trouble?

Check the [documentation](https://laravel.com/docs/10.x#laravel-and-docker) for more info on running laravel on docker.
