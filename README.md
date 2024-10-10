# 🚀 Proyecto Laravel con Docker

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)

## 📝 Descripción

Este proyecto es una aplicación web desarrollada con **Laravel**, utilizando **Docker** y **Docker Compose** para la gestión de contenedores. Incluye una base de datos **MySQL** y está configurado para facilitar el desarrollo y despliegue de la aplicación.

## 📋 Prerrequisitos

Antes de comenzar, asegúrate de tener instalado lo siguiente en tu máquina:

- [Docker](https://www.docker.com/get-started) 🐳
- [Docker Compose](https://docs.docker.com/compose/install/) 🐳

## 🔧 Instalación

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/Jlozoya1/to-do
   cd to-do
   ```

2. **Configurar las variables de entorno**

   Crea una copia del archivo `.env.example` y renómbrala a `.env`.

   ```bash
   cp .env.example .env
   ```

   Edita el archivo `.env` con tus configuraciones:

   ```env
   DB_DATABASE=nombre_de_la_base_de_datos
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   # DB_ROOT_PASSWORD=tu_contraseña_segura (para producción)
   ```

## 🛠️ Uso

### 📦 Iniciar los Contenedores

Para construir y levantar los contenedores de Docker, ejecuta:

```bash
docker-compose up -d --build
```

Esto hará lo siguiente:

- Construirá la imagen de la aplicación Laravel.
- Descargarás la imagen de MySQL si aún no la tienes.
- Creará y levantará los contenedores en segundo plano.

### 🔄 Migrar la Base de Datos

Para ejecutar las migraciones de Laravel dentro del contenedor `myApp`, utiliza:

```bash
docker-compose exec myApp php artisan migrate
```

### 🐘 Acceder a la Aplicación

Una vez que los contenedores estén levantados y las migraciones ejecutadas, puedes acceder a la aplicación en tu navegador en:

🌐 **[http://localhost:8000](http://localhost:8000)**

### 🐳 Verificar el Estado de los Contenedores

Para ver el estado de los contenedores en ejecución:

```bash
docker-compose ps
```

Si el contenedor mysql no corre, crear una base de datos en localhost:3306 llamada "to_do_list"
despues hacer dentro de la terminal denrto del proyecto 

```bash
php artisan migrate
php artisan db:seed
```

Por defecto tendra que haber un usuario llamado Test User con correo test@tes.com, passw: 12345678
