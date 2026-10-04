# San Isidro - Base de Datos

Sistema de gestión para el negocio San Isidro.

## Descripción

Proyecto desarrollado para la asignatura de Bases de Datos.

## Tecnologías

- HTML
- CSS
- JavaScript
- PHP
- PDO
- SQL Server

## Estado del proyecto

 En desarrollo


 # Super-San-Isidro

Sistema de gestión para el proyecto Super-San-Isidro.

## Estado actual del proyecto

El proyecto se encuentra actualmente en una etapa de desarrollo beta, enfocada inicialmente en comprobar y establecer las funcionalidades principales del sistema antes de desarrollar todos los módulos de manera completa.

En esta etapa se implementó el sistema de autenticación y acceso al sistema mediante PHP, SQL Server y sesiones.

---

## Implementación actual

### 1. Base de datos

Se estableció la estructura inicial necesaria para el sistema de usuarios:

* Tabla `roles`.
* Tabla `usuarios`.
* Relación entre usuarios y roles mediante una clave foránea.
* Rol inicial `Administrador`.
* Usuario administrador para realizar las pruebas del sistema.

La contraseña del usuario no se almacena directamente, sino mediante un hash generado con `password_hash()`.

---

### 2. Conexión con SQL Server

El proyecto utiliza una conexión centralizada mediante:

```text
config/conexion.php
```

La conexión se realiza mediante PDO y el controlador de SQL Server.

La base de datos utilizada actualmente es:

```text
PruebaLaragonSQ1L
```

---

### 3. Sistema de Login

Se modificó el formulario existente de Login para permitir el envío de las credenciales mediante `POST`.

El formulario envía:

* Usuario.
* Contraseña.

Los datos son procesados mediante:

```text
controllers/LoginProcess.php
```

Este archivo:

1. Recibe las credenciales.
2. Consulta el usuario en SQL Server.
3. Obtiene el rol asociado.
4. Verifica la contraseña mediante `password_verify()`.
5. Crea una sesión PHP.
6. Almacena los datos principales del usuario.
7. Redirige al Dashboard cuando la autenticación es correcta.

---

### 4. Sesiones

Después de una autenticación correcta se almacenan en la sesión datos como:

* `id_usuario`
* `usuario`
* `nombre`
* `id_rol`
* `rol`

Esto permite que las diferentes páginas del sistema puedan identificar al usuario autenticado y posteriormente aplicar permisos de acuerdo con su rol.

---

### 5. Dashboard

Se creó:

```text
assets/html/Dashboard.php
```

El Dashboard utiliza la sesión activa para mostrar información del usuario autenticado.

Actualmente muestra:

* Nombre del usuario.
* Nombre de usuario.
* Rol.
* Panel principal.
* Tarjetas correspondientes a los módulos principales del sistema.

Los módulos representados actualmente son:

* Usuarios.
* Proveedores y Compras.
* Inventario.
* Producción.
* Productos.
* Ventas y Clientes.
* Costos.
* Movimientos Especiales.

Por el momento, estas tarjetas funcionan como representación visual de los módulos y no contienen todavía toda su funcionalidad.

---

### 6. Protección del Dashboard

El Dashboard verifica que exista una sesión activa antes de permitir el acceso.

Si una persona intenta acceder directamente al Dashboard sin haber iniciado sesión, el sistema la redirige nuevamente al Login.

Esto establece el control básico de acceso para usuarios autenticados.

---

### 7. Cierre de sesión

Se creó:

```text
controllers/Logout.php
```

Este archivo:

1. Inicia la sesión actual.
2. Elimina los datos de sesión.
3. Destruye la sesión.
4. Redirige al usuario hacia el Login.

También se agregó la opción de **Cerrar sesión** dentro del Dashboard.

---

## Estructura relevante actual

```text
Super-San-Isidro/
│
├── assets/
│   ├── css/
│   │   ├── Login.css
│   │   └── Dashboard.css
│   │
│   ├── fonts/
│   ├── html/
│   │   ├── Login.html
│   │   └── Dashboard.php
│   │
│   └── images/
│
├── config/
│   └── conexion.php
│
├── controllers/
│   ├── LoginProcess.php
│   └── Logout.php
│
├── database/
│
├── docs/
│   └── versiones_diseños/
│
├── .gitignore
├── .php-preview-router.php
└── README.md
```

---

## Flujo actual del sistema

```text
Login.html
    │
    ▼
LoginProcess.php
    │
    ▼
conexion.php
    │
    ▼
SQL Server
    │
    ├── usuarios
    └── roles
    │
    ▼
Verificación de contraseña
    │
    ▼
Sesión PHP
    │
    ▼
Dashboard.php
    │
    ▼
Trabajo dentro del sistema
    │
    ▼
Logout.php
    │
    ▼
Login.html
```

---

## Estado de desarrollo

### Implementado

* [x] Conexión PHP con SQL Server.
* [x] Tabla de roles.
* [x] Tabla de usuarios.
* [x] Relación usuarios-roles.
* [x] Usuario administrador.
* [x] Contraseña almacenada mediante hash.
* [x] Login funcional.
* [x] Verificación de credenciales.
* [x] Creación de sesiones.
* [x] Protección del Dashboard.
* [x] Dashboard inicial.
* [x] Cierre de sesión.
* [x] Redirección al Login después de cerrar sesión.
 
### Pendiente

* [ ] Gestión completa de usuarios.
* [ ] Gestión de proveedores y compras.
* [ ] Inventario de materias primas.
* [ ] Producción primaria.
* [ ] Producción secundaria.
* [ ] Gestión de productos.
* [ ] Inventario de productos terminados.
* [ ] Clientes y ventas.
* [ ] Gestión de costos.
* [ ] Movimientos especiales.
* [ ] Control detallado de permisos por rol.

Los módulos pendientes se desarrollarán progresivamente durante las siguientes etapas del proyecto.
