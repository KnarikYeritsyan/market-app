# Deploy Server laravel project

## making up server environment

### xampp
- **[install xampp on ubuntu server](https://www.9lessons.info/2015/12/amazon-ec2-setup-with-ubuntu-and-xampp.html)**

```
sudo apt-get update
wget https://www.apachefriends.org/xampp-files/7.3.15/xampp-linux-x64-7.3.15-0-installer.run
sudo chmod +x xampp-linux-x64-7.3.15-0-installer.run
sudo ./xampp-linux-x64-7.3.15-0-installer.run
sudo /opt/lampp/lampp restart
```
**Configure httpd**
```
nano /opt/lampp/etc/extra/httpd-xampp.conf
```
change to
````
# since XAMPP 1.4.3
<Directory "/opt/lampp/phpmyadmin">
AllowOverride AuthConfig Limit
Order allow,deny
Allow from all
Require all granted
ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
</Directory>
````
**Security Settings**
```
sudo /opt/lampp/xampp security
```
#### install composer
- **[install composer on ubuntu server](https://www.ionos.com/community/hosting/php/install-and-use-php-composer-on-ubuntu-1604/)**
```
sudo apt-get update
sudo apt-get install curl
sudo curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
#### setup laravel project
``cd /opt/lampp/htdocs``, clone repository with git, add ``.htaccess`` file and paste this
```
vi /opt/lampp/htdocs/.htaccess
```
```
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/market/public/
RewriteRule (.*) /market/public/$1
```
.htaccess with port
```
RewriteEngine on
RewriteCond  %{SERVER_PORT} ^80$
RewriteCond %{REQUEST_URI} !^/market_vuejs/dist/
RewriteRule (.*) /market_vuejs/dist/$1

RewriteCond  %{SERVER_PORT} ^8080$
RewriteCond %{REQUEST_URI} !^/market/public/
RewriteRule (.*) /market/public/$1
```
add ``.env`` file to project (look at the .env1 file)
```
vi /opt/lampp/htdocs/market/.env
```
**instal composer dependencies**
```
composer install --ignore-platform-reqs
```
clear configs
```
/opt/lampp/bin/php artisan config:cache
/opt/lampp/bin/php artisan cache:clear
/opt/lampp/bin/php artisan config:clear
```
change permissions
```
sudo chown -R ubuntu:www-data storage
sudo chown -R ubuntu:www-data public
sudo chmod -R 777 storage
sudo chmod -R 777 /opt/lampp/htdocs/market/storage/logs
sudo chmod -R 777 /opt/lampp/htdocs/market/public
sudo chmod -R 777 /opt/lampp/htdocs/market/public/assets/
sudo chmod -R 777 bootstrap/cache
```
migrate the project
```
/opt/lampp/bin/php artisan migrate
```
run db seeder
```
/opt/lampp/bin/php artisan db:seed
```
seed folders
```
cd public/assets && mkdir brands && mkdir categories && mkdir pages && mkdir products && mkdir sliders && mkdir settings
mkdir brands/img_resize && mkdir categories/img_resize && mkdir pages/img_resize && mkdir products/img_resize && mkdir sliders/img_resize
mkdir brands/img && mkdir categories/img && mkdir pages/img && mkdir products/img && mkdir sliders/img
```

### to open server port go to following files

```
vi /opt/lampp/etc/original/httpd.conf
vi /opt/lampp/etc/httpd.conf 
```
add this line
```
Listen 8080
```