# Sistema de préstamo de equipos

Sistema web en Laravel para llevar el control de los equipos que presta el laboratorio (laptops, proyectores, kits Arduino, multímetros, etc.).

## Qué hace

- Login con usuario y contraseña, y cierre de sesión.
- Dos roles: **Encargado** y **Estudiante**, cada uno con su propio panel.
- El Encargado registra, ve, edita y elimina equipos, y presta y devuelve equipos.
- El Estudiante solo ve los equipos disponibles.
- Las páginas internas están protegidas: sin iniciar sesión no se puede entrar.

## Tecnologías

- PHP 8.2+ / Laravel 11 (backend)
- Blade, Tailwind CSS y Vite (frontend)
- MySQL (con XAMPP y phpMyAdmin)

## Requisitos

- PHP 8.2 o superior
- Composer
- XAMPP (Apache y MySQL)
- Node.js y npm

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/chepsito20081/sistema-prestamos.git
   cd sistema-prestamos
   ```

2. Instalar dependencias de PHP:

   ```bash
   composer install
   ```

3. Instalar dependencias de Node.js:

   ```bash
   npm install
   ```

   > En Windows PowerShell, si da error de permisos, usar `npm.cmd install`.

4. Copiar el archivo de entorno y generar la clave:

   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

5. En phpMyAdmin crear la base de datos `prestamo_equipos`.

6. En el archivo `.env` dejar estas líneas:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=prestamo_equipos
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Crear las tablas y cargar los datos de prueba (1 encargado, 2 estudiantes y 8 equipos):

   ```bash
   php artisan migrate --seed
   ```

8. Compilar los estilos (en una terminal aparte):

   ```bash
   npm run dev
   ```

9. Iniciar el servidor:

   ```bash
   php artisan serve
   ```

10. Abrir `http://127.0.0.1:8000` en el navegador.

## Usuarios de prueba

| Rol        | Correo            | Contraseña |
|------------|-------------------|------------|
| Encargado  | xavi@gmail.com    | Tecsup2025 |
| Estudiante | leonel@gmail.com  | Tecsup2025 |
| Estudiante | tomas@gmail.com   | Tecsup2025 |