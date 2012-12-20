#!/bin/bash
cd ..
phpab --exclude 'app/public/*' --output app/autoload.php app
