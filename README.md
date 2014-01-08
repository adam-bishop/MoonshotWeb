# MoonshotWeb

A basic website for interacting with an attribute authority

### Installation

Installation is based RedHat.

#### Installing Apache HTTPD, PHP, and MySQL

```
sudo yum install httpd php
sudo yum install php-mysqli mysql-server
sudo yum install mysql php-mysql
sudo yum install mysql-connector-java
sudo cp /usr/share/java/mysql-connector-java.jar $IDP_HOME/lib 
sudo apachectl restart
sudo service mysqld start
```

#### Configuring the Database

```
mysql -u root [-p password]
CREATE DATABASE attprovider;
USE attprovider;
CREATE TABLE attributes (id int NOT NULL AUTO_ICNREMENT PRIMARY KEY, identity varchar(150) NOT NULL COMMENT 'Identity being referenced');
```

#### Adding the Website

In order to add the website, the files need to be copied to the ```/var/www/html``` directory. From within those files, a configuration file can be found - ```includes/config.php```. The details for the database host, username, password, database name, and table name should be updated here if necessary.
