# Deploy Server vue.js project

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

#### node.js
- **[install node on ubuntu server](https://computingforgeeks.com/how-to-install-nodejs-on-ubuntu-debian-linux-mint/)**
```
sudo apt update
sudo apt -y upgrade
sudo apt -y install curl dirmngr apt-transport-https lsb-release ca-certificates
curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -
sudo apt -y install nodejs
```
##### setup vue.js project
clone repository with git, build the project
````
npm run build
````
it will create a folder named ```dist```, inside that folder create an ```.htaccess``` file and paste the following
([htaccess](https://stackoverflow.com/questions/44172993/vue-js-routing-issue-in-apache))
````
vi /var/www/html/market_vuejs/dist/.htaccess
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^index\.html$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /index.html [L]
</IfModule>
````



[md online](https://dillinger.io/)