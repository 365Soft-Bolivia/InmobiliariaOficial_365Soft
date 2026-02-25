# 🚀 Guía de Despliegue en Railway

Guía paso a paso para desplegar el Sistema de Gestión Inmobiliaria 365Soft en Railway.

## ✅ Configuraciones Implementadas

### 1. ✅ nixpacks.toml - Forzar PHP 8.3
**Estado**: Completado
**Archivo**: [`nixpacks.toml`](nixpacks.toml)

```toml
[phases.setup]
nixPkgs = ["php83", "php83Packages.composer", "nodejs_22"]
```

Este archivo configura Railway para usar PHP 8.3, Node.js 22 y Composer automáticamente.

### 2. ✅ composer.json - Versión PHP Requerida
**Estado**: Completado
**Cambio**: `"php": "^8.2"` → `"php": "^8.3"`

El proyecto ahora requiere PHP 8.3+ para coincidir con la versión instalada en Railway.

### 3. ✅ .gitignore - .env Excluido
**Estado**: Ya existía (línea 14)
**Verificación**: `.env` está correctamente excluido del repositorio.

### 4. ✅ Carpetas storage - .gitkeep Creados
**Estado**: Completado
**Archivos creados**:
- `storage/framework/cache/data/.gitkeep`
- `storage/framework/sessions/.gitkeep`
- `storage/framework/views/.gitkeep`
- `storage/framework/testing/.gitkeep`
- `storage/logs/.gitkeep`

Estas carpetas ahora serán trackeadas por Git y creadas automáticamente en Railway.

### 5. ✅ APP_KEY Generada
**Estado**: Completado
**Valor**: `base64:LPbxX5v96sDgIFQdHF0prp0/YcDomxmS4qFi77S2GTw=`

Esta clave debe configurarse como variable de entorno en Railway.

---

## 📋 Pasos Restantes para Desplegar

### Paso 1: Crear Proyecto en Railway

1. Ve a [railway.app](https://railway.app/)
2. Crea una nueva cuenta o inicia sesión
3. Clic en **"New Project"**
4. Selecciona **"Deploy from GitHub repo"**

### Paso 2: Conectar Repositorio

1. Conecta tu cuenta de GitHub si aún no lo has hecho
2. Selecciona el repositorio `InmobiliariaOficial_365Soft`
3. Railway detectará automáticamente el archivo `nixpacks.toml`

### Paso 3: Agregar Servicio MySQL

1. En tu proyecto de Railway, clic en **"New Service"**
2. Selecciona **Database** → **MySQL**
3. Railway creará automáticamente las siguientes variables de entorno:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `MYSQLDATABASE`
   - `MYSQLPUBLIC_PORT`
   - `MYSQLPRIVATEPORT`
   - `MYSQLHOST_PRIVATE`

### Paso 4: Configurar Variables de Entorno

Ve a **Settings** → **Variables** y agrega las siguientes variables:

#### Variables Generales

| Variable | Valor | Descripción |
|----------|-------|-------------|
| `APP_KEY` | `base64:LPbxX5v96sDgIFQdHF0prp0/YcDomxmS4qFi77S2GTw=` | Clave de encriptación de Laravel |
| `APP_ENV` | `production` | Ambiente de producción |
| `APP_DEBUG` | `false` | Desactivar modo debug |
| `APP_URL` | (URL de Railway) | Se autocompleta al desplegar |

#### Base de Datos (mapear variables de MySQL a Laravel)

| Variable | Valor | Descripción |
|----------|-------|-------------|
| `DB_CONNECTION` | `mysql` | Tipo de conexión |
| `DB_HOST` | `${MYSQLHOST}` | Host de MySQL (Railway variable) |
| `DB_PORT` | `${MYSQLPORT}` | Puerto de MySQL (Railway variable) |
| `DB_DATABASE` | `${MYSQLDATABASE}` | Nombre de BD (Railway variable) |
| `DB_USERNAME` | `${MYSQLUSER}` | Usuario de BD (Railway variable) |
| `DB_PASSWORD` | `${MYSQLPASSWORD}` | Password de BD (Railway variable) |

**Nota**: Railway permite referencias a otras variables usando `${VARIABLE_NAME}`

#### Otras Variables (del .env.example)

| Variable | Valor | Descripción |
|----------|-------|-------------|
| `APP_NAME` | `"Inmobiliaria 365Soft"` | Nombre del sistema |
| `LOG_CHANNEL` | `stack` | Canal de logs |
| `LOG_LEVEL` | `error` | Nivel de logging |
| `BROADCAST_DRIVER` | `log` | Driver de broadcast |
| `CACHE_DRIVER` | `file` | Driver de caché |
| `FILESYSTEM_DISK` | `local` | Disco filesystem |
| `QUEUE_CONNECTION` | `database` | Conexión de cola |
| `SESSION_DRIVER` | `file` | Driver de sesión |
| `SESSION_LIFETIME` | `120` | Vida de sesión (minutos) |

#### Variables API Externa (si se usa)

| Variable | Valor | Descripción |
|----------|-------|-------------|
| `EXTERNAL_API_URL` | `https://fifusa.site/api/v1/products` | URL de API externa |
| `EXTERNAL_API_KEY` | `68d382c6-63fb-4736-9669-f4e230efb2e1` | API Key |
| `EXTERNAL_API_CACHE_DURATION` | `300` | Caché (segundos) |
| `EXTERNAL_API_TIMEOUT` | `30` | Timeout (segundos) |

### Paso 5: Ejecutar Migraciones

El archivo `nixpacks.toml` ya incluye el comando para ejecutar migraciones automáticamente:

```bash
php artisan migrate --force
```

Las migraciones se ejecutarán automáticamente durante el despliegue.

### Paso 6: Verificar Despliegue

1. Railway te proporcionará una URL pública (ej: `https://tu-app.railway.app`)
2. Visita la URL para verificar que la aplicación funciona
3. Revisa los logs en **Logs** → **Deploy Logs** para ver si hay errores

---

## 🔧 Troubleshooting

### Error: "Class not found"

**Solución**: Limpiar caché de composer
```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

### Error: "SQLSTATE connection refused"

**Solución**: Verificar que las variables de BD estén correctamente mapeadas a las variables de MySQL de Railway:
- `DB_HOST` → `${MYSQLHOST}`
- `DB_PORT` → `${MYSQLPORT}`
- etc.

### Error: "Storage permission denied"

**Solución**: Los archivos `.gitkeep` creados deberían solucionar esto. Si persiste, agregar script de permisos en nixpacks.toml.

### Error: "APP_KEY not set"

**Solución**: Asegúrate de agregar la variable `APP_KEY` en Settings → Variables de Railway.

---

## 📊 Monitoreo en Railway

### Logs en Tiempo Real
- Ve a **Logs** → **Deploy Logs** para ver logs de construcción
- Ve a **Logs** → **Runtime Logs** para logs de ejecución

### Métricas
- Railway muestra métricas de CPU, memoria y red en tiempo real
- Configura alertas en **Settings** → **Alerts**

### Deploys
- Cada push a la rama principal activará un nuevo deploy
- Puedes ver el historial en **Deploys**

---

## 🌐 Dominio Personalizado (Opcional)

1. Ve a **Settings** → **Domains**
2. Agrega tu dominio personalizado
3. Configura los DNS según las instrucciones de Railway:
   - Tipo: `CNAME`
   - Nombre: `@` o tu subdominio
   - Valor: `[tu-proyecto].railway.app`

---

## 🔄 Actualizar la Aplicación

Para actualizar la aplicación en producción:

```bash
# Hacer cambios localmente
git add .
git commit -m "Descripción de cambios"
git push origin main
```

Railway detectará el push y ejecutará un nuevo deploy automáticamente.

---

## 📝 Checklist Final

Antes de desplegar, verificar:

- [x] `nixpacks.toml` creado con PHP 8.3
- [x] `composer.json` actualizado a PHP ^8.3
- [x] `.env` en `.gitignore`
- [x] Carpetas `storage/` con `.gitkeep`
- [x] `APP_KEY` generada
- [ ] Proyecto creado en Railway
- [ ] Repositorio de GitHub conectado
- [ ] Servicio MySQL agregado
- [ ] Variables de entorno configuradas
- [ ] Despliegue verificado en URL pública

---

## 📚 Recursos Útiles

- [Documentación de Railway](https://docs.railway.app/)
- [Documentación de Nixpacks](https://nixpacks.com/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)

---

**Generado**: 2025-02-25
**Sistema**: InmobiliariaOficial_365Soft v1.0
**Stack**: Laravel 12 + Vue 3 + TypeScript
