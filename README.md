# Agenda Personal de Contactos

Aplicación web desarrollada en PHP y MySQL que permite a los usuarios registrar una cuenta, iniciar sesión y administrar sus contactos personales desde una interfaz sencilla.

##  Aplicación desplegada

**Enlace público:** [https://agenda-contactos-utpl.great-site.net/login.php](https://agenda-contactos-utpl.great-site.net/login.php)

## Tecnologías utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- PDO
- XAMPP
- InfinityFree

## Funcionalidades principales

- Registro de usuarios.
- Inicio y cierre de sesión.
- Administración de contactos.
- Agregar, editar y eliminar contactos.
- Búsqueda por nombre, correo electrónico o ciudad.
- Ordenamiento por fecha, nombre y ciudad.
- Clasificación de contactos por categorías.
- Marcado y filtrado de contactos favoritos.
- Acceso individual a los contactos de cada usuario.

## Seguridad

- Contraseñas protegidas mediante `password_hash()` y `password_verify()`.
- Consultas preparadas mediante PDO.
- Manejo de sesiones.
- Protección CSRF.
- Validación y escape de datos para evitar la inserción de contenido HTML no deseado.
- Relación de los contactos con el usuario correspondiente mediante claves foráneas.

## Requisitos para instalación local

- XAMPP.
- PHP 8.4 o compatible.
- MySQL.
- Navegador web.
- Visual Studio Code.

## Instalación local

1. Descargar o clonar el repositorio de GitHub.
2. Copiar la carpeta del proyecto dentro del directorio `htdocs` de XAMPP.
3. Iniciar Apache y MySQL desde el panel de XAMPP.
4. Abrir phpMyAdmin.
5. Crear una base de datos llamada `agenda_contactos`.
6. Importar el archivo `database/agenda_contactos.sql`.
7. Revisar la configuración de conexión en `config/conexion.php`, utilizando los datos de la instalación local.
8. Abrir el proyecto desde el navegador:

   [http://localhost/agenda_contactos/](http://localhost/agenda_contactos/)

## Estructura del proyecto

```text
agenda_contactos/
│
├── config/
│   └── conexion.php
│
├── css/
│   └── estilos.css
│
├── database/
│   └── agenda_contactos.sql
│
├── includes/
│   └── auth.php
│
├── index.php
├── registro.php
├── login.php
├── dashboard.php
├── agregar_contacto.php
├── listar_contactos.php
├── editar_contacto.php
├── eliminar_contacto.php
├── logout.php
│
├── README.md
└── .gitignore
```
## Mejoras implementadas respecto a la versión anterior

Se incorporaron las siguientes mejoras para facilitar la administración de los contactos:

- **Búsqueda:** permite localizar contactos por nombre, correo electrónico o ciudad.
- **Ordenamiento:** permite organizar los contactos por nombre, ciudad y fecha de creación.
- **Categorías:** se incorporó la clasificación de contactos en Familia, Amigos, Trabajo, Universidad y Otro.
- **Favoritos:** permite marcar contactos como favoritos y visualizar únicamente los contactos seleccionados.

## Despliegue web

La aplicación fue publicada utilizando el servicio de hosting gratuito InfinityFree y una base de datos MySQL.

**URL pública:**

[https://agenda-contactos-utpl.great-site.net/](https://agenda-contactos-utpl.great-site.net/)

**Inicio de sesión:**

[https://agenda-contactos-utpl.great-site.net/login.php](https://agenda-contactos-utpl.great-site.net/login.php)

## Autor

Proyecto académico desarrollado como parte de la formación universitaria en Ingeniería en Tecnologías de la Información.
