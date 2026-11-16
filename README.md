# Agenda Personal de Contactos

## Descripción del proyecto

La Agenda Personal de Contactos es una aplicación web desarrollada con PHP y MySQL que permite a los usuarios registrarse, iniciar sesión y administrar sus contactos personales desde una interfaz sencilla.

El sistema permite que cada usuario gestione su propia información de manera independiente, evitando que pueda visualizar o modificar los contactos pertenecientes a otras cuentas.

Este proyecto fue desarrollado como parte de la actividad académica sobre metodologías de desarrollo web, aplicando conceptos de programación orientada a eventos, autenticación, manejo de sesiones y conexión con bases de datos.

## Tecnologías utilizadas

- **PHP:** desarrollo de la lógica del sistema.
- **MySQL / MariaDB:** almacenamiento y administración de la información.
- **HTML5:** estructura de las páginas web.
- **CSS3:** diseño y presentación visual.
- **XAMPP:** entorno de desarrollo local.
- **phpMyAdmin:** administración de la base de datos.

## Funcionalidades principales

- Registro de nuevos usuarios.
- Inicio y cierre de sesión.
- Autenticación mediante correo electrónico y contraseña.
- Registro de contactos personales.
- Consulta de contactos registrados.
- Edición de la información de los contactos.
- Eliminación de contactos.
- Separación de contactos según la cuenta del usuario.
- Validación de los datos ingresados en los formularios.

## Seguridad implementada

Para proteger la información de los usuarios, se aplicaron algunas medidas de seguridad:

- **Contraseñas cifradas:** se utiliza `password_hash()` para almacenar las contraseñas de forma segura y `password_verify()` para comprobarlas durante el inicio de sesión.
- **Consultas preparadas:** se utiliza PDO y consultas preparadas para reducir el riesgo de inyección SQL.
- **Control de sesiones:** se verifica que el usuario haya iniciado sesión antes de acceder a las páginas privadas.
- **Protección CSRF:** se implementan tokens de seguridad en los formularios que modifican información.
- **Protección de datos:** se utiliza `htmlspecialchars()` para evitar la interpretación de contenido HTML no confiable.
- **Separación de información:** cada contacto se relaciona con el usuario que lo registró mediante una clave foránea.

## Requisitos para ejecutar el proyecto

- Windows o un sistema operativo compatible.
- XAMPP instalado.
- PHP 8.4 o una versión compatible.
- MySQL o MariaDB.
- Navegador web actualizado.

## Instalación y ejecución

1. Instalar y abrir XAMPP.
2. Iniciar los servicios de Apache y MySQL.
3. Copiar la carpeta `agenda_contactos` dentro del directorio `htdocs` de XAMPP.
4. Ingresar a phpMyAdmin desde `http://localhost/phpmyadmin/`.
5. Crear una base de datos llamada `agenda_contactos`.
6. Seleccionar la base de datos e importar el archivo `database/agenda_contactos.sql`.
7. Verificar los datos de conexión en el archivo `config/conexion.php`. Si se utilizan credenciales diferentes, actualizarlas.
8. Abrir el navegador e ingresar a:

   `http://localhost/agenda_contactos/`

9. Registrarse con una cuenta nueva e iniciar sesión para utilizar la aplicación.

## Estructura del proyecto

```text
agenda_contactos/
│
├── config/
│   └── conexion.php
│
├── includes/
│   └── auth.php
│
├── css/
│   └── estilos.css
│
├── database/
│   └── agenda_contactos.sql
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
└── README.md
```

## Autor

Proyecto académico desarrollado como parte de la actividad de desarrollo web con PHP y MySQL.