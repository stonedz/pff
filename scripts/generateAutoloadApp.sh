#!/bin/bash
cd ..
phpab --exclude 'app/vendor/doctrine/common/tests*' \
    --exclude 'app/vendor/doctrine/dbal/tests*' \
    --exclude 'app/vendor/doctrine/orm/tests*' \
    --exclude 'app/public/*' \
	--output app/autoload.php app

