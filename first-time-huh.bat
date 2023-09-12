@echo off
echo --- GENERATING OPENSSL KEY PAIR ---
sleep 1
echo Generate Private Key providence.pem
sleep 1
openssl genrsa -out providence.pem 2048
echo Generate Public Key providence-public.pem
sleep 1
openssl rsa -in providence.pem -pubout -out providence-public.pem

echo --- INSTALLING APP DEPS ---
echo Install dependecies from Composer for PHP 
sleep 1
composer install
echo Install dependecies from npm for JS
sleep 1
npm install

echo --- CONFIGURING APP ---
echo Setup envfile
copy .env.example .env
echo Generate Laravel Key 
sleep 1
php artisan generate:key
echo Update GeoIP database 
sleep 1
php artisan geoip:update