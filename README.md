# Nombre del Proyecto

Esta es una prueba para la vacante desarrollador PHP junior, la cual fue desarrollada bajo los parametros y el alcance del PDF suministrado por Suplos para dicha prueba.

## Instalación

1. Clona el repositorio: `git clone <URL del repositorio>`
2. Ingresa al directorio del proyecto: `cd <nombre del directorio>`
3. Instala las dependencias: `npm install`
4. Instala composer
5. importar base de datos que se encuentra en la carpeta config

## Uso

Para ejecutar este proyecto se debe utilizar el comando npm run serve despues de hacer la previa instalacion.
## IMPORTANTE 
para que la actualización de estados funcione, se debe tener un archivo crontab con el siguiente comando : * * * * * cd /opt/lampp/htdocs/prueba_php_vue/prueba_backend_vue/ && /usr/bin/php actualizacion.php, EN CASO DEL USO DE OTRO SERVIDOR O CAMBOS EN EL NOMBRE DEL PROYECTO, SE DEBE AJUSTAR LA RUTA PARA QUE EL ARCHIVO PUEDA SER EJECUTADO


## Características

Esta funcionalidad ha sido creada para la creacion, vizualizacion, actualizacion y descarga de un conjunto de datos suministrados por el cliente.

En la primera vista el cliente podra observar las diferentes opciones que tiene a su dispocision empezando por un apartado para crear un nuevo proceso/evento donde se le brinda un formulario en el cual podra especificar los datos de su proceso/evento a crear, en la siguiente opcion podra adicionar uno o varios archivos de tipo PDF, WORD y EXCEL a el proceso/evento deseado filtrandolo por su nombre Objeto, en esta vista tambien tendra la opcion de descargar los documentos adjuntos al registro en visualizacion , en la ultima opcion tendras la funcionalidad de hacer consultas a los registros de procesos/eventos ya creados y visualizarlos en pantalla o si bien lo desea puede generar un excel de el proceso/evento que desee.

## Tecnologías utilizadas

npm
Vue 2.6.14 
axios 1.4.0
core-js 3.8.3
vue-router 3.0
vuetify 2.6.15
node js
PHP 8.1.10
mysqlnd 8.1.10
SweetAlert 2.1.2
Composer 2.5.5

## Autor

Prueba suministrada por la empresa Suplos.
Realizada por Vanessa Peña