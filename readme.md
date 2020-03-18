## Setup

Install
- Apache
- PHP
- MySQL

Add `127.0.0.1 symfony.csv` to /etc/hosts

Go to /etc/apache2/sites-available, create file symfony.csv.conf
```bash
<VirtualHost *:80>
    ServerName symfony.csv
    ServerAlias symfony.csv
    DocumentRoot /var/www/symfony-csv/public
    <Directory /var/www/symfony-csv/public>
        AllowOverride All
    </Directory>
</VirtualHost>
```
Go to /etc/apache2/sites-enabled, run

`a2ensite symfony.csv`

`sudo service apache2 restart`

Go to /var/www/symfony-csv/, run

`composer install`

### Database
For starting work with project, you should create empty database.
Configure DATABASE_URL in `.env` according your database settings