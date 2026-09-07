# AXIS — Adaptive eXperience & Intelligence System

Plataforma comercial de entrenamiento para vendedores, construida para **Advance**.  
Digitaliza el proceso estructurado de capacitación basado en *Los 9 Pasos de la Venta Advance* y la fórmula pedagógica **HERRAMIENTA + Hábito + Habilidad = Capacidad Comercial**.

---

## Stack

| Capa | Tecnología |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Admin UI | Filament v5 |
| Base de datos | MariaDB |
| Assets | Vite / npm (via nvm) |
| Servidor local | XAMPP (ruta personalizada) |
| Túnel público | Cloudflare Tunnel |

---

## Requisitos previos

- PHP 8.2 (XAMPP en `C:\xampp\php`)
- Composer (`php composer.phar` desde la raíz del proyecto)
- Node.js via [nvm-windows](https://github.com/coreybutler/nvm-windows)
- MariaDB corriendo (incluido en XAMPP)

> **Windows:** Asegúrate de que PowerShell tenga política de ejecución `RemoteSigned`:
> ```powershell
> Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
> ```

---

## Instalación

### 1. Clonar el repositorio

```powershell
git clone https://github.com/loratrusty/axis.git
cd axis
```

### 2. Instalar dependencias PHP

```powershell
php composer.phar install
```

### 3. Instalar dependencias Node

```powershell
nvm use 20
npm install
```

### 4. Configurar el entorno

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Edita `.env` y configura:

```env
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=axis
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
```

### 5. Crear la base de datos

Crea una base de datos llamada `axis` en MariaDB/phpMyAdmin, luego:

```powershell
php artisan migrate --seed
```

### 6. Compilar assets

```powershell
npm run build
```

---

## Levantar el servidor

Abre **dos terminales** en PowerShell:

**Terminal 1 — Servidor Laravel:**
```powershell
php artisan serve
```

**Terminal 2 — (Opcional) Túnel Cloudflare:**
```powershell
cloudflared tunnel run axis
```

La aplicación queda disponible en `http://127.0.0.1:8000`.

---

## Paneles disponibles

| Panel | Ruta | Acceso |
|---|---|---|
| Admin | `/admin` | Rol `admin` |
| Coach | `/coach` | Rol `coach` |
| Gerencia | `/gerencia` | Rol `manager` |
| Trainee | `/mi-programa` | Rol `trainee` |

---

## Estructura de roles

El acceso a cada panel se controla mediante `canAccessPanel()` en cada `PanelProvider`.  
Los roles se asignan desde el panel Admin.

---

## Notas de entorno (Windows / XAMPP)

- El PATH de PHP debe apuntar a `C:\xampp-actual-v2\php` (no a una versión anterior).
- Composer se ejecuta como `php composer.phar`, no como comando global.
- El driver de sesión debe ser `file` para evitar problemas con sesiones en XAMPP.
- Si el proyecto está detrás de HTTPS via Cloudflare Tunnel, el esquema de URL se fuerza en `AppServiceProvider`.

---

## Comandos útiles

```powershell
# Limpiar caché
php artisan optimize:clear

# Recompilar assets en modo watch (desarrollo)
npm run dev

# Ver logs
Get-Content storage\logs\laravel.log -Tail 50 -Wait
