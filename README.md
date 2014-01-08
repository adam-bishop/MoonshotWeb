# MoonshotWeb

A basic website for interacting with an attribute authority

### Installation

#### Installing Apache HTTPD, PHP, and MySQL

```
sudo yum install sudo yum install sudo yum install sudo yum install
httpd php
php-mysqli mysql-server mysql php-mysql
mysql -connector -java
sudo cp
/usr/share/java/mysql -connector -java.jar
$IDP_HOME/lib sudo apachectl restart
sudo service mysqld start
```

#### Configuring the Database

```
mysql -u root [-p password]
CREATE DATABASE attprovider;
use attprovider;
CREATE TABLE attributes (id int NOT NULL AUTO_ICNREMENT PRIMARY KEY, identity varchar(150) NOT NULL COMMENT 'Identity being referenced');
```
