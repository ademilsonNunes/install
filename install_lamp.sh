#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

# Ubuntu 20.04 dev Server
# Run like - bash install_lamp.sh
# Script should auto terminate on errors

echo -e "\e[96m Linux System Upgrade  \e[39m"
sudo sudo apt-get -y dist-upgrade

echo -e "\e[96m Adding PPA  \e[39m"
sudo add-apt-repository -y ppa:ondrej/apache2
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update

echo -e "\e[96m Installing apache  \e[39m"
sudo apt-get -y install apache2

echo -e "\e[96m Installing php  \e[39m"
sudo apt-get -y install php7.4 libapache2-mod-php7.4

# Install some php exts
sudo apt-get -y install curl zip unzip php7.4-mysql php7.4-curl php7.4-soap php7.4-ctype php7.4-uuid php7.4-iconv php7.4-json php7.4-mbstring php7.4-gd php7.4-intl php7.4-xml php7.4-zip php7.4-gettext php7.4-pgsql php7.4-bcmath php7.4-redis
#sudo apt-get -y install php-xdebug
sudo phpenmod curl

# Enable some apache modules
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo a2enmod  php7.4

echo -e "\e[96m Config PHP.ini  \e[39m"
sudo chmod -R 777 /etc/php/7.4/apache2/php.ini
echo "" >> /etc/php/7.4/apache2/php.ini
echo "error_log = /tmp/php_errors.log" >> /etc/php/7.4/apache2/php.ini
echo "display_errors = On"             >> /etc/php/7.4/apache2/php.ini
echo "memory_limit = 256M"             >> /etc/php/7.4/apache2/php.ini
echo "max_execution_time = 120"        >> /etc/php/7.4/apache2/php.ini
echo "error_reporting = E_ALL"         >> /etc/php/7.4/apache2/php.ini
echo "file_uploads = On"               >> /etc/php/7.4/apache2/php.ini
echo "post_max_size = 100M"            >> /etc/php/7.4/apache2/php.ini
echo "upload_max_filesize = 100M"      >> /etc/php/7.4/apache2/php.ini
echo "session.gc_maxlifetime = 14000"  >> /etc/php/7.4/apache2/php.ini

echo -e "\e[96m Restart apache server to reflect changes  \e[39m"
sudo service apache2 restart

echo -e "\e[96m Install MySQL Server  \e[39m"
sudo apt-get -y install mysql-server
sudo apt-get update
sudo apt-get -y install software-properties-common
sudo apt-add-repository -y ppa:rael-gc/rvm
sudo apt-get update
sudo apt-get -y install rvm

echo -e "\e[96m Install Dependencies from pdo_sqlsrv  \e[39m"
## install dependencies from sql_srv driver to SQL Server Connect
## fixar bug
cd ~
sudo bash -c 'curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -'
sudo bash -c 'curl https://packages.microsoft.com/config/ubuntu/18.04/prod.list > /etc/apt/sources.list.d/mssql-release.list'
#exit 

sudo ACCEPT_EULA=Y apt-get -y install msodbcsql17 
sudo ACCEPT_EULA=Y apt-get -y install mssql-tools 
sudo chmod -R 777 /opt/mssql-tools/bin
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile
echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
source ~/.bashrc
sudo apt-get -y install unixodbc-dev 

## Install sql_srv extension
echo -e "\e[96m install sql_srv extension  \e[39m"
sudo pecl install sqlsrv
sudo pecl install pdo_sqlsrv

## config sql_srv extension
printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/7.4/mods-available/sqlsrv.ini
printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/7.4/mods-available/pdo_sqlsrv.ini
#exit
sudo phpenmod -v 7.4 sqlsrv pdo_sqlsrv 

# Download and install composer 
echo -e "\e[96m Installing composer \e[39m"
# Notice: Still using the good old way
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --force --filename=composer
# Add this line to your .bash_profile
# export PATH=~/.composer/vendor/bin:$PATH

echo -e "\e[96m Installing psysh \e[39m"
sudo wget https://psysh.org/psysh -O /usr/local/bin/psysh
sudo chmod +x /usr/local/bin/psysh

# Check php version
echo -e "\e[96m Check php version \e[39m"
php -v

# Check apache version
echo -e "\e[96m Check apache version \e[39m"
apachectl -v

# Check if php is working or not
echo -e "\e[96m Check if php is working or not \e[39m"
php -r 'echo "\nYour PHP installation is working fine.\n";'

# Fix composer folder permissions
echo -e "\e[96m Fix composer folder permissions \e[39m"
mkdir -p ~/.composer
sudo chown -R $USER $HOME/.composer

# Check composer version
echo -e "\e[96m Check composer version \e[39m"
composer --version


echo -e "\e[92m Open http://localhost/ to check if apache is working or not. \e[39m"

# Install SpaceVim 
echo -e "\e[96m Install SpaceVim  \e[39m"
sudo bash -c  'curl -sLf https://spacevim.org/install.sh | bash'
#exit

# Clean up cache
sudo apt-get clean

