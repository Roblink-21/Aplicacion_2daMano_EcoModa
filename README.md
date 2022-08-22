# Instalación del componente Backend

## Requerimientos 

- XAMPP
- Node JS
- Composer
- Laravel
- Git
- MYSQL (Optional)

## Intrucciones para la instalación

### Clonar el repositorio
Se debe realizar a traves del CLI, la clonacion del repositorio. 
Para lo cual se debera ejecutar el siguiente comando:

$ git clone --branch sprint3 https://github.com/Roblink-21/Aplicacion_2daMano_EcoModa.git

### Instalación de dependencias
Ejecutar el siguiente comando para obtener las dependencias necesarias para el archivo composer.json

$ composer install

### Creacion de una base de datos SQL
Para obtener los registros, es necesario utilizar un gestor de base de datos el cual pueda conectarse al proyecto de Laravel y de esta forma realizar las migraciones.

### Crear el archivo .env
Para realizar las conexiones con servicios de terceros, es necesario duplicar el archivo:

$ .env.example

El cual tiene todas las variables de entorno necesarias para realizar las conexiones de los servicios con Laravel.

### Migraciones
El proyecto utiliza datos Fakes, los cuales son registros generados automaticamente por la aplicacion.

$ php artisan migrate:fresh --seed

### Iniciar el proyecto
Una vez realizada las migraciones, el proyecto estaria listo para utilizarse.
Usar el siguiente comando para iniciar el proyecto:

$ php artisan serve
