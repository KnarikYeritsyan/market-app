# Deploy Server laravel project

## making up server environment

#### apache
- **[install apache on ubuntu server](https://phoenixnap.com/kb/how-to-install-apache-web-server-on-ubuntu-18-04)**

```
sudo apt-get update
sudo apt-get install apache2
sudo ufw allow 'Apache'
sudo a2enmod rewrite
sudo service apache2 restart
systemctl restart apache2
enable module - sudo a2enmod name_of_module
disable module - sudo a2dismod name_of_module
```
Configuration Files
```
website content - /var/www/html/
error logs - /var/log/apache2/error.log
main Apache configuration file - /etc/apache2/apache2.conf
port configuration file - /etc/apache2/ports.conf
virtual host files - /etc/apache2/sites-available
```
- **[change apache document root folder](https://askubuntu.com/questions/337874/change-apache-document-root-folder-to-secondary-hard-drive)**
- **[Enable .htaccess File On Apache](https://phoenixnap.com/kb/how-to-set-up-enable-htaccess-apache)**

```
vi /etc/apache2/sites-available/000-default.conf
```
**Edit the DocumentRoot option:**
```
DocumentRoot /path/to/my/project
```
```
vi /etc/apache2/apache2.conf
```
**Change to**
```
<Directory />                                                                                                               
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted                                                                                                
</Directory>
  
<Directory /var/www/>                                                                                                           
    Options Indexes FollowSymLinks                                                                                          
    AllowOverride All                                                                                                       
    Require all granted                                                                                             
</Directory> 
```
**or exchange ```/var/www/``` to ```/path/to/my/project```**
```
<Directory  /var/www/html/market_vuejs/dist>                                                                                                           
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted                                                                                             
</Directory>  
```

then
```
sudo service apache2 restart
```

- **[install php7.4 on ubuntu](https://computingforgeeks.com/how-to-install-php-on-ubuntu/)**
```
sudo apt install php7.4-common php7.4-mysql php7.4-xml php7.4-xmlrpc php7.4-curl php7.4-gd php7.4-imagick php7.4-cli php7.4-dev php7.4-imap php7.4-mbstring php7.4-opcache php7.4-soap php7.4-zip php7.4-intl -y
```
- **[install mysql on ubuntu](https://support.rackspace.com/how-to/install-mysql-server-on-the-ubuntu-operating-system/)**
- **[install lamp stack on ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04)**
- **[install lamp stack on ubuntu](https://www.bennetrichter.de/en/tutorials/apache2-php7-mysql-phpmyadmin/)**
```
sudo apt-get update
sudo apt-get install mysql-server
sudo mysql_secure_installation utility
sudo ufw allow mysql
sudo systemctl start mysql
/etc/init.d/mysql start
sudo systemctl enable mysql
vi /etc/mysql/mysql.conf.d/mysqld.cnf
sudo systemctl restart mysql
check if working
/usr/bin/mysql -u root -p
```
- **[install phpMyadmin on ubuntu](https://www.hostingadvice.com/how-to/install-phpmyadmin-on-ubuntu/)**
```
sudo apt-get update
sudo apt-get install -y phpmyadmin

```
#### install composer
- **[install composer on ubuntu server](https://www.ionos.com/community/hosting/php/install-and-use-php-composer-on-ubuntu-1604/)**
```
sudo apt-get update
sudo apt-get install curl
sudo curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
 
**[to fix phpmyadmin errors for MySql 5.7+ follow this gide](https://devanswers.co/phpmyadmin-access-denied-for-user-root-localhost/#method-1-create-a-new-superuser-for-phpmyadmin)**

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