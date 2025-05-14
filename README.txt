Proceso de compilación del proyecto en local (Para Windows):

1.Instalar XAMPP (https://www.apachefriends.org/es/index.html)
2.Una vez instalado, instalar Composer (https://getcomposer.org/)
*Durante la instalación de composer comprobar que la ruta de instalación sea: C:\xampp\php\php.exe
4.Instalar NODE.JS (https://nodejs.org/es)
5.Instalar Visual Studio Code (https://code.visualstudio.com/)

Una vez lo tenemos todo instalado añadiremos dentro de la carpeta C:\xampp\htdocs el proyecto (Vetnet).
Abrimos desde esa dirección el terminal con permisos de Administrador y desde ahi ejecutamos los siguientes comandos:
1.composer install (si salen mensajes de failed to download... es normal)
2.npm install

Ahora dentro del proyecto debemos comprobar que en la carpeta raiz del proyecto exista el archivo .env (No .env.example)
y que contenga la siguiente información:
APP_NAME=Vetnet
APP_ENV=local
APP_KEY=base64:Xw2Zowfotr/j+CCkgs+XTgFm3qOAEGLg1kKcHYsw4y0=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vetnet
DB_USERNAME=root
DB_PASSWORD=

Del resto de parametros no hay que modificar nada.

Una vez hayamos indicado la conexión con la BBDD abrimos XAMPP y arrancamos los servicios de Apache y MySQL (los dos primeros)

Nos dirigimos a http://localhost/phpmyadmin/ y le damos a crear una nueva BBDD donde simplemente escribimos el nombre: vetnet y 
nos aseguramos que la codificación sea utf8mb4_general_ci.

Una vez creada la base de datos y levantados los servicios en el xampp volvemos al terminal y ejecutamos:
php artisan migrate

Una vez finalizado el proceso se deberían haber creado todas las tablas en la BBDD.

Finalmente, para comprobar que el proyecto funciona, volvemos al terminal y ejecutamos:
php artisan serve

Nos dirigimos dentro del navegador y acedemos a: http://127.0.0.1:8000/

Deberia dirigirnos a la página de login.
Por defecto al levntar la base de datos la primera vez ya estaria creado el usuario admin con estas credenciales:
email: admin@vetnet.com
password: admin1234