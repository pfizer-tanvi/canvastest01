# create databases
CREATE DATABASE IF NOT EXISTS `test`;
CREATE DATABASE IF NOT EXISTS `default`;

# create root user and grant rights
CREATE USER 'root'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';