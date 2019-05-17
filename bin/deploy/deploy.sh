#!/bin/bash
sudo chmod -R 777 /var/www/www-root/data/www/smartmarket.by
cd /var/www/www-root/data/www/smartmarket.by
sudo cp -r sollentomarket/* .
sudo rm -r sollentomarket
cd ../
sudo chmod -R 777 smartmarket.by
cd smartmarket.by/
mkdir web/uploads
mkdir web/uploads/img/
mkdir web/uploads/img/product
mkdir web/uploads/img/news
sudo chmod -R 777 web/uploads
cp -r web/test_data/img/product/* web/uploads/img/product
cp -r web/test_data/img/news/* web/uploads/img/news
if [[ ! -f app/config/parameters.yml ]]; then
    cp app/config/parameters.yml.dist app/config/parameters.yml
fi
#fuser -n tcp -k 5555
php bin/console doctrine:migrations:migrate --no-interaction
#mysql -uroot -proot sollento_market < bin/sql/sollento_market.sql
sudo service apache2 restart
