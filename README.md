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
   git clone https://github.com/tu_usuario/tu_proyecto.git
   cd tu_proyecto
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

### 📄 Generar la Clave de la Aplicación

Si aún no has generado una clave de aplicación para Laravel, hazlo con:

```bash
docker-compose exec myApp php artisan key:generate
```

### 🐘 Acceder a la Aplicación

Una vez que los contenedores estén levantados y las migraciones ejecutadas, puedes acceder a la aplicación en tu navegador en:

🌐 **[http://localhost:8000](http://localhost:8000)**

### 🐳 Verificar el Estado de los Contenedores

Para ver el estado de los contenedores en ejecución:

```bash
docker-compose ps
```

### 📋 Ver los Logs de los Contenedores

Para ver los logs del contenedor de la aplicación:

```bash
docker-compose logs myApp
```

Para ver los logs del contenedor de la base de datos:

```bash
docker-compose logs BDatos
```

### 🛑 Detener los Contenedores

Para detener y eliminar los contenedores, redes y volúmenes definidos en `docker-compose.yml`:

```bash
docker-compose down
```

Para detener y eliminar contenedores y volúmenes, usa:

```bash
docker-compose down -v
```

**⚠️ Advertencia:** Esto eliminará todos los datos almacenados en la base de datos.

### 🧹 Limpiar Volúmenes de Docker (Opcional)

Si necesitas eliminar un volumen específico:

1. **Listar los volúmenes existentes:**

   ```bash
   docker volume ls
   ```

2. **Eliminar el volumen `db_data`:**

   ```bash
   docker volume rm db_data
   ```

### 🛠️ Reconstruir los Contenedores

Si realizaste cambios en el `Dockerfile` o en las dependencias, puedes reconstruir las imágenes y levantar los contenedores nuevamente:

```bash
docker-compose up -d --build
```

## 🔍 Conexión a la Base de Datos

Puedes conectarte a la base de datos MySQL utilizando herramientas como [MySQL Workbench](https://www.mysql.com/products/workbench/) o desde la línea de comandos.

### 📊 Detalles de Conexión

- **Host:** `localhost` o `127.0.0.1`
- **Puerto:** `3306` (si usaste el mapeo por defecto)
- **Usuario:** El valor de `DB_USERNAME` en tu `.env` (por ejemplo, `tu_usuario`)
- **Contraseña:** El valor de `DB_PASSWORD` en tu `.env` (por ejemplo, `tu_contraseña`)

**Nota:** Si estás usando `MYSQL_ALLOW_EMPTY_PASSWORD: 'yes'`, la contraseña estará vacía para el usuario root.

### 🐬 Ejemplo de Conexión desde la Línea de Comandos

```bash
mysql -h 127.0.0.1 -P 3306 -u tu_usuario -p
```

Presiona `Enter` cuando se te solicite la contraseña si permites contraseñas vacías.

## 📂 Estructura del Proyecto

```plaintext
├── app/                # Código de la aplicación
├── database/
├── docker-compose.yml  # Configuración de Docker Compose
├── Dockerfile          # Configuración del Dockerfile para la aplicación
├── .env                # Variables de entorno
├── README.md
└── ...
```

## 🐛 Solución de Problemas

### ❌ Error: `The designated data directory /var/lib/mysql/ is unusable`

1. **Detener y eliminar contenedores y volúmenes existentes:**

   ```bash
   docker-compose down -v
   ```

2. **Verificar y eliminar manualmente el volumen `db_data` (si aún existe):**

   ```bash
   docker volume ls
   docker volume rm db_data
   ```

3. **Reiniciar los contenedores para recrear los volúmenes:**

   ```bash
   docker-compose up -d --build
   ```

4. **Verificar los logs del contenedor de MySQL:**

   ```bash
   docker-compose logs BDatos
   ```

### ❗ Otros Errores Comunes

- **Composer falla por falta de Git:**
  
  Asegúrate de que Git esté instalado en el contenedor. Puedes modificar tu `Dockerfile` para instalar Git, como se mostró anteriormente.

### 🧹 Limpiar el Directorio de Datos de MySQL

Si necesitas limpiar manualmente el directorio de datos de MySQL, sigue estos pasos:

1. **Ejecutar un Contenedor Temporal para Acceder al Volumen:**

   ```bash
   docker run --rm -it -v db_data:/var/lib/mysql alpine sh
   ```

2. **Dentro del Contenedor, Eliminar los Archivos en `/var/lib/mysql/`:**

   ```sh
   rm -rf /var/lib/mysql/*
   exit
   ```

3. **Reiniciar los Contenedores:**

   ```bash
   docker-compose up -d --build
   ```

### 🔄 Actualizar el Archivo `docker-compose.yml`

Asegúrate de que tu archivo `docker-compose.yml` esté correctamente configurado para evitar conflictos y problemas de permisos.

#### Ejemplo de `docker-compose.yml` Optimizado:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: myApp
    ports:
      - '8000:80'
    volumes:
      - .:/var/www/html
    depends_on:
      - db
    networks:
      - app-network
    env_file:
      - .env

  db:
    image: mysql:8.0
    container_name: BDatos
    restart: unless-stopped
    environment:
      MYSQL_ALLOW_EMPTY_PASSWORD: 'yes' # Solo para desarrollo; no recomendado para producción
      # MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD} # Descomenta para producción
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    ports:
      - '3306:3306'
    volumes:
      - db_data:/var/lib/mysql
    networks:
      - app-network
    env_file:
      - .env

volumes:
  db_data:

networks:
  app-network:
```

**Notas Importantes:**

- **`MYSQL_ALLOW_EMPTY_PASSWORD`:** Permitir contraseñas vacías es conveniente para entornos de desarrollo, pero **no es seguro para producción**. Para entornos de producción, define una contraseña segura utilizando `MYSQL_ROOT_PASSWORD`.
  
- **Volumen Nombrado (`db_data`):** Usar volúmenes nombrados ayuda a evitar conflictos y problemas de permisos.

## 📚 Recursos Adicionales

- [Documentación Oficial de Laravel](https://laravel.com/docs)
- [Documentación de Docker](https://docs.docker.com/)
- [Documentación de Docker Compose](https://docs.docker.com/compose/)
- [Dockerizing a Laravel Application](https://laravel.com/docs/8.x/sail#using-docker)

## 📧 Contacto

Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en contactarme.

---

**¡Gracias por usar este proyecto!** 🙌
