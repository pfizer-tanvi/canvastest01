#!/bin/bash
# Script to generate SQL for creating dbs for a new app stack.

# inputs: appName, appEnv

pwd=$(openssl rand -base64 12)
appName=$1
appEnv=$2

cat << EOF > create-db-${appEnv}.sql 

CREATE DATABASE ${appName}_${appEnv};
CREATE USER ${appName}_${appEnv}@'%' IDENTIFIED BY '$pwd';
CREATE USER ${appName}_${appEnv}@'localhost' IDENTIFIED BY '$pwd';
GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, CREATE, DROP, ALTER, INDEX, TRIGGER, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EXECUTE, CREATE TEMPORARY TABLES, LOCK TABLES, SHOW DATABASES ON *.* TO '${appName}_${appEnv}'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, REFERENCES, CREATE, DROP, ALTER, INDEX, TRIGGER, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EXECUTE, CREATE TEMPORARY TABLES, LOCK TABLES, SHOW DATABASES ON *.* TO '${appName}_${appEnv}'@'%';
FLUSH PRIVILEGES;
EOF

echo "create-db-${appEnv}.sql has been created for you"