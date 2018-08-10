# dbrecover

## Abstruct
This MariaDB recovery script is based on CentOS 7. The internal shell script is written in bash.

## Setting

1. composer install
````
$ composer install
````

2. .env setting
````
$ cd /DIR/
$ mv .env.sample .env
$ vi .env
````
Permission 777 may be necessary depending on the conditions for the directory where Log is saved.

3. exec  
It works with execute permission can restart MariaDB.

````
$ su root
# php db_recover.php
````

## Cron Setting

Example:
````
# cd ~
# crontab -e
````
Monitor every minute and restart when the DB server is down.
````
*/1 * * * *    php /home/system-nowhite/batch/dbrecover/db_recover.php >/dev/null 2>&1
````
