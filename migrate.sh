#!/bin/bash
# migrate

clear
echo
echo Migrating...
echo
php artisan migrate
echo
echo
echo Seeding...
echo
php artisan db:seed --class=DemoSeeder
echo
echo
