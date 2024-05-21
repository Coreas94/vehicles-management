# Proyecto de Gestión de Vehículos

Este proyecto es una aplicación web para la gestión de vehículos, propietarios y el historial de propiedad de vehículos. La aplicación permite realizar operaciones CRUD sobre vehículos y propietarios, así como importar datos desde un archivo Excel.

## Tabla de Contenidos

- [Descripción](#descripción)
- [Características](#características)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Uso](#uso)
- [Pruebas](#pruebas)

## Descripción

Esta aplicación permite gestionar la información de vehículos y propietarios, y mantener un registro histórico de las propiedades de los vehículos. También permite importar datos desde un archivo Excel.

## Características

- CRUD de vehículos y usuarios
- Importación de datos desde archivos Excel
- Gestión de historial de propiedad de vehículos
- Envío de correo electrónico de notificación al procesar archivo excel
- Soft delete para la eliminación de registros sin pérdida de datos

## Requisitos

- PHP >= 8.0
- Composer
- Laravel = 11.x
- MySQL
- Node.js y NPM

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tu_usuario/gestion-vehiculos.git
   cd gestion-vehiculos

2. Instala las dependencias de PHP:
   ```bash
   composer install

4. Instala las dependencias de Node.js:
   ```bash
   npm install

6. Ejecuta las migraciones y los seeders para crear las tablas en la base de datos vehicles_project:
   ```bash
   php artisan migrate

## Uso

1. Para iniciar el servidor de desarrollo:
   ```bash
   php artisan serve

2. Para compilar los activos front-end:
   ```bash
   npm run dev

3. Ir al navegador y acceder a:
   ```bash
   http://localhost:8000/

## Pruebas

1. Para ejecutar las pruebas, utiliza el siguiente comando:
   ```bash
   php artisan test
