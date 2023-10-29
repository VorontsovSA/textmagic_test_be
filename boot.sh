#!/bin/bash
set -e

composer install
npm install
npm run build
php bin/console doctrine:migrations:migrate --no-interaction
