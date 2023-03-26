# Desafío Técnico
Este proyecto es una aplicación web que permite la gestión de viáticos de agentes. Permite subir una planilla en formato CSV con los datos de los agentes que realizaron un viaje para guardarlos en una base de datos.

## Requisitos previos
Antes de instalar la aplicación, asegúrate de cumplir los siguientes requisitos:

- PHP 8.x o superior
- MySQL 8.0 o superior
- Composer

Estos son los requisitos con los que se ha probado la aplicación y se garantiza su compatibilidad. Es posible que funcione con versiones anteriores o posteriores, pero no se ha probado y no se garantiza su funcionamiento.

## Instalacíon
Este proyecto se ha desarrollado con Laravel y MySQL. A continuación se detallan los pasos necesarios para instalar y desplegar la aplicación.

1. Clonar el repositorio desde GitHub:
    ``` bash
    git clone https://github.com/tdornell/desafio-tecnico-subse.git
    ```

2. Entrar a la carpeta del proyecto:
    ``` bash
    cd desafio-tecnico-subse
    ```

3. Instalar las dependencias de Laravel con Composer:
    ``` bash
    composer install
    ```

4. Crear una base de datos en MySQL y configurar las credenciales en el archivo [.env](desafio-tecnico-subse/.env#L11):
    ``` sh
    ...
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_la_base_de_datos
    DB_USERNAME=usuario_mysql
    DB_PASSWORD=contraseña_de_mysql
    ...
    ```

5. Correr las migraciones para crear la tabla `viajes` en la base de datos:
    ``` bash
    php artisan migrate
    ```

6. Iniciar el servidor de desarrollo de Laravel:
    ``` bash
    php artisan serve
    ```

## Uso
1. Acceder a la página a traves de un navegador:
    - [http://localhost:8000](http://localhost:8000)

2. Seleccionar un archivo CSV con los datos de los agentes. Los campos son:
    - Nombre
    - Apellido
    - Documento
    - Organismo
    - Viáticos asignados (número decimal con hasta 10 dígitos enteros y 2 decimales)
    - Fecha de inicio del viaje (YYYY-MM-DD)
    - Fecha de fin del viaje (YYYY-MM-DD)

3. Presionar el botón `Subir` para validar los datos y luego guardarlos en la base de datos.

4. Luego se mostrará un mensaje indicando si la operación fue exitosa o si hubo algún problema durante el proceso. En caso de que ocurra algún error, el mensaje detallara donde a ocurrido el error.

## Validaciones
El sistema valida que:
- La conexión a la base de datos sea correcta.
- Se haya seleccionado un archivo.
- El archivo sea CSV.
- El archivo CSV no esté vacío.
- El archivo CSV tenga el formato correcto (cantidad de columnas por fila).
- Los tipos de datos de cada columna sean correctos.

## Archivo de prueba
Para probar la funcionalidad de la aplicación, se proporciona un archivo CSV con datos ficticios de agentes, este se encuentra en [extra/datos_de_prueba.csv](extra/datos_de_prueba.csv).