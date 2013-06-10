#!/bin/bash
cd ..
phpab --exclude 'app/vendor/doctrine/common/tests*' \
    --exclude 'app/vendor/doctrine/dbal/tests*' \
    --exclude 'app/vendor/doctrine/orm/tests*' \
    --exclude 'app/public/*' \
	--exclude 'app/vendor/hybridauth/hybridauth/additional-providers/*' \
	--exclude 'app/vendor/dompdf/dompdf/lib/php-font-lib/*' \
	--output app/autoload.php app

