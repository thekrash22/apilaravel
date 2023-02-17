<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requisitos

Docker instalado en el sistema.

### Pasos para la instalación
1.  Clonar este repositorio.
2.  Acceder a la carpeta del proyecto.
3.  Crear el archivo .env con la siguiente configuracion
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db
```

4.  Construir la imagen de Docker:
```bash
docker compose build app 
```
5. Subir los contenedores con:

```bash
docker compose up -d 
```
6.  Ingresamos al contenedor app e instalamos laravel con composer install.
```bash
docker compose exec app bash
composer install 
```
7. Corremos comandos para agrear llave, migraciones y seeder:
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed --class=UserSeeder
```
ya con esto quedaria instalado el proyecto.
#### Nota: 
el seeder crea los siguientes usuarios con su contraseña:
```bash
user@user.com => password
customer@customer.com => password
client@client.com => password
```


Oswaldo Gonzalez.
