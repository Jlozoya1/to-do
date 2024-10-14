# 🚀 To-Do List App - Laravel + Sail

Este proyecto es una aplicación de **Lista de Tareas** construida con **Laravel** y configurada para ejecutarse utilizando **Laravel Sail** (Docker). A continuación te explico cómo configurarlo y ejecutarlo fácilmente utilizando Sail.

## 📋 Prerrequisitos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos en tu sistema:

- [Docker](https://www.docker.com/get-started) 🐳

## 🛠️ Instalación

### 1. Clonar el repositorio

Clona el repositorio en tu máquina local:

```bash
git clone https://github.com/tu-usuario/to-do-list.git
cd to-do-list
```

### 2. Configurar el archivo `.env`

Copia el archivo de configuración `.env.example` a `.env` y ajusta las variables necesarias, como la configuración de la base de datos:

```bash
cp .env.example .env
```

### 3. Instalar dependencias

Para instalar las dependencias del proyecto, usa Sail con Composer:

```bash
./vendor/bin/sail composer install
```
Tambien deberas de editar el puerto por defecto que te genera el SAIL

### 4. Migrar la base de datos

Ejecuta las migraciones de la base de datos para crear las tablas necesarias:

```bash
./vendor/bin/sail artisan migrate
```

## 🚀 Cómo Ejecutar el Proyecto

### Levantar los servicios con Laravel Sail

Para levantar el entorno Docker de Sail, ejecuta:

```bash
./vendor/bin/sail up -d
```

Esto levantará los servicios de Docker (PHP, MySQL, Redis, etc.) en segundo plano.

### Acceder a la aplicación

Una vez que los servicios estén levantados, puedes acceder a la aplicación en tu navegador en:

```
http://localhost:8000
```

### Ejecutar comandos usando Sail

Puedes ejecutar comandos de Laravel Artisan o Composer usando Sail. Algunos ejemplos:

- **Ejecutar Artisan:**

  ```bash
  ./vendor/bin/sail artisan migrate
  ```
