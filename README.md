## Lien vers la PROD
https://r301.kilya.coop/

Identifiants:
admin    admin

## Configuration Apache
### MODs à installer
php
php-mysql
rewrite

### Configuration du virtual host
```
<VirtualHost *:80>
    ServerName ${serverName}
    DocumentRoot /var/www/${serverName}

    <Directory "/var/www/${serverName}">
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all grantedd
    </Directory>

    RewriteEngine On
    RewriteCond %{REQUEST_URI} !\.(css|jpg)$
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</VirtualHost>
```

## Technologies utilisées
- HTML
- CSS
- PHP
- PDO (pour la gestion de la base de données)
- MySQL

