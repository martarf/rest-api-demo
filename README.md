Basic RESTful API with Silex + Doctrine2
========================

1) Instalación
----------------------------------

Descargamos el proyecto

    git clone https://github.com/martarf/rest-api-demo.git rest-api-demo

Ejecutamos el sql necesario para probar la base de datos (app/config/database.sql).

Descargamos composer

    curl -s https://getcomposer.org/installer | php

Instalamos dependencias

    php composer.phar install

Configuramos el virtual host de apache

```
<VirtualHost *:80>
    ServerName rest-api-demo.local
    DocumentRoot /Users/atram/Sites/rest-api-demo/web
    DirectoryIndex index.php

    <Directory "/Users/atram/Sites/rest-api-demo/web">
        AllowOverride All
        Allow from All
    </Directory>
</VirtualHost>
```

Añadimos el host en /etc/hosts

    127.0.0.1   rest-api-demo.local

Si todo va bien deberíamos poder cargar la página

    http://rest-api-demo.local

Y probar la api (GET,POST,PUT,DELETE):

    PROD: http://antevenio.local/api/v1/countries

    DEV: http://antevenio.local/api/v1/index_dev.php/countries

    PROD: http://rest-api-demo.local/api/v1/countries/1

    DEV: http://rest-api-demo.local/api/v1/index_dev.php/countries/1

Para probar los test

    phpunit -c app/ tests



