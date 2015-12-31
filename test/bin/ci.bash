#!/bin/bash

set -e

SCRIPTFILE=$(readlink -f "$0")
SCRIPTDIR=$(dirname "$SCRIPTFILE")

phpunit -c "$SCRIPTDIR/../../phpunit.dist.xml" --coverage-clover "$SCRIPTDIR/../../build/logs/clover.xml"

# $SCRIPTDIR/phpcs.bash $1


if [ "$PROCESS_CODECLIMATE" = true ] && [ "${TRAVIS_PULL_REQUEST}" = "false" ] && [ "${TRAVIS_BRANCH}" = "master" ]
then

    composer require codeclimate/php-test-reporter:dev-master

    ./vendor/bin/test-reporter
fi
