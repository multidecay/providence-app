#!/usr/bin/sh

echo "--- INSTALING DEPS --- \n" && \
composer install && \
npm install

echo "--- GENERATE KEYPAIR OPENSSL ---" && \
openssl genrsa -out providence.pem 2048 && \
openssl rsa -in providence.pem -pubout -out providence-public.pem

echo "--- CONFGURING APP --- \n" && \
cp .env.example .env && \
php artisan generate:key && \
php artisan geoip:update 

