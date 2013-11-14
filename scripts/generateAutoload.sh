#!/bin/bash

cd ..
phpab --exclude 'lib/vendor/ezyang/htmlpurifier/maintenance/*' \
    --exclude 'lib/vendor/doctrine/common/tests*' \
    --exclude 'lib/vendor/doctrine/dbal/tests*' \
    --exclude 'lib/vendor/doctrine/orm/tests*' \
    --exclude 'lib/vendor/smarty/smarty/development*' \
    --exclude 'lib/vendor/swiftmailer/swiftmailer/test-suite*' \
    --exclude 'lib/vendor/swiftmailer/swiftmailer/tests*' \
    --exclude '*/tests/*' \
    --output lib/autoload.php lib

phpab --output tests/autoload.php tests

phpab --exclude 'app/vendor/doctrine/common/tests*' \
    --exclude 'app/vendor/doctrine/dbal/tests*' \
    --exclude 'app/vendor/doctrine/orm/tests*' \
    --exclude 'app/public/*' \
    --exclude 'app/vendor/hybridauth/hybridauth/additional-providers/*' \
    --exclude 'app/vendor/dompdf/dompdf/lib/php-font-lib/*' \
    --output app/autoload.php app
