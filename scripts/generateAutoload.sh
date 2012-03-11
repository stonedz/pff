#!/bin/bash

cd ..
phpab --output lib/autoload.php lib
phpab --output tests/autoload.php tests