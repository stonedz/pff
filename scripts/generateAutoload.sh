#!/bin/bash

cd ..
phpab --exclude 'lib/vendor/ezyang/htmlpurifier/maintenance/*' \
    --exclude 'lib/vendor/doctrine/common/tests*' \
    --exclude 'lib/vendor/doctrine/dbal/tests*' \
    --exclude 'lib/vendor/doctrine/orm/tests*' \
    --exclude 'lib/vendor/smarty/smarty/development*' \
    --exclude 'lib/vendor/swiftmailer/swiftmailer/test-suite*' \
    --exclude 'lib/vendor/swiftmailer/swiftmailer/tests*' \
        --output lib/autoload.php lib
phpab --output tests/autoload.php tests
phpab --output app/autoload.php app
