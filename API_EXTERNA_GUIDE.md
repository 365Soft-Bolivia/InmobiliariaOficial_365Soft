# Guía de Integración con API Externa

Esta guía explica cómo se ha integrado el sistema para consumir datos de una API externa en lugar de usar la base de datos local para el catálogo público de propiedades.

## 🎯 Objetivo

Reemplazar el consumo de datos de la base de datos local por la API externa `https://fifusa.site/api/v1/products` para mostrar el catálogo público de propiedades, manteniendo toda la funcionalidad existente.

## 📁 Archivos Modificados y Creados

### Nuevos Archivos Creados

1. **`app/Services/ExternalApiService.php`**
   - Servicio principal para consumir la API externa
   - Maneja caché, formateo de datos y errores
   - Soporta paginación y filtros básicos

2. **`app/Services/ExternalPropertyFilterService.php`**
   - Adaptador del servicio de filtros para la API externa
   - Mantiene la misma interfaz que `PropertyFilterService`
   - Aplica filtros localmente (la API externa no soporta filtros complejos)

3. **`app/Http/Controllers/Public/PropiedadPublicControllerWithApi.php`**
   - Controlador que usa la API externa
   - Mantenemos el controlador original como respaldo
   - Manejo de errores y fallback

4. **`test_api_externa.php`**
   - Script de prueba para verificar el funcionamiento

### Archivos Modificados

1. **`routes/public.php`**
   - Nuevas rutas bajo el prefijo `/api-externa/`
   - Rutas originales intactas

2. **`config/services.php`**
   - Configuración para la API externa

3. **`.env`**
   - Variables de configuración para la URL de la API

4. **`app/Providers/AppServiceProvider.php`**
   - Registro de los nuevos servicios

## 🚀 Configuración

### Variables de Entorno

Agrega las siguientes variables a tu archivo `.env`:

```env
EXTERNAL_API_URL=https://fifusa.site/api/v1/products
EXTERNAL_API_KEY= 
EXTERNAL_API_CACHE_DURATION=300
EXTERNAL_API_TIMEOUT=30
```

⚠️ **IMPORTANTE**: La API ahora requiere autenticación mediante el header `X-API-KEY`. Sin esta clave, la API retornará un error 401 con el mensaje: "API Key requerida. Incluir en header X-API-KEY."

### Configuración por Defecto

El sistema ya incluye configuraciones por defecto en `config/services.php`:

```php
'external_api' => [
    'url' => env('EXTERNAL_API_URL', 'https://fifusa.site/api/v1/products'),
    'key' => env('EXTERNAL_API_KEY', ''),
    'cache_duration' => env('EXTERNAL_API_CACHE_DURATION', 300), // 5 minutos
    'timeout' => env('EXTERNAL_API_TIMEOUT', 30),
],
```

## 🔐 Autenticación

### Header X-API-KEY

La API externa ahora requiere autenticación mediante un header HTTP personalizado:

```
X-API-KEY: 68d382c6-63fb-4736-9669-f4e230efb2e1
```

Esta clave se configura automáticamente en el archivo `.env` y es utilizada por el servicio `ExternalApiService` en todas las peticiones a la API.

### Implementación en el Servicio

El servicio `ExternalApiService` incluye automáticamente el header en todas las peticiones:

```php
$response = Http::timeout(30)
    ->withHeaders([
        'X-API-KEY' => $this->apiKey,
        'Accept' => 'application/json',
    ])
    ->get($url);
```

### Seguridad

- **Nunca compartir la API Key** públicamente o en repositorios públicos
- **Rotación de claves**: Si la clave es comprometida, solicitar una nueva al proveedor de la API
- **Ambientes**: Usar claves diferentes para desarrollo y producción
- **Logs**: El sistema NO incluye la API Key en los logs por seguridad

## 🛠️ Rutas Disponibles

### Rutas de Prueba (API Externa)

- **Listado de propiedades**: `GET /api-externa/propiedades`
- **Detalle de propiedad**: `GET /api-externa/propiedad/{id}`
- **Mapa de propiedades**: `GET /api-externa/mapa-propiedades`

### Rutas Originales (Base de Datos)

- **Listado de propiedades**: `GET /propiedades`
- **Detalle de propiedad**: `GET /propiedad/{id}`
- **Mapa de propiedades**: `GET /mapa-propiedades`

## 📊 Mapeo de Datos

La API externa devuelve datos con una estructura diferente a la base de datos local. El sistema mapea los campos automáticamente:

### Campos Mapeados

| API Externa | Sistema Local |
|-------------|---------------|
| `nombre` | `name` |
| `codigo_inmueble` | `codigo_inmueble` |
| `precio` | `price` |
| `descripcion` | `descripcion` |
| `operacion` | `operacion` |
| `categoria.nombre` | `category_name` |
| `imagenes` | `images` |
| `imagen_portada` | `imagen_portada` |
| `caracteristicas.*` | Campos de características |
| `agente_captador` | `agente_captador` |

### Campos no Disponibles en la API

- **Ubicación geográfica**: `location` (null)
- **Dirección**: `direccion` (null)
- **Teléfono de agente**: `phone` (null)

## 🔧 Funcionalidades Implementadas

### 1. Listado de Propiedades
- ✅ Paginación soportada
- ✅ Filtros básicos implementados:
  - Categoría
  - Operación (venta/alquiler)
  - Código de inmueble
  - Rango de precios
  - Características (ambientes, habitaciones, baños, cocheras)

### 2. Detalle de Propiedad
- ✅ Información completa del producto
- ✅ Galería de imágenes
- ✅ Información del agente
- ✅ Propiedades relacionadas

### 3. Mapa Interactivo
- ✅ Estructura preparada (sin ubicación real)
- ⚠️ Limitado por falta de datos geográficos en la API

### 4. Caché
- ✅ Caché automático de 5 minutos
- ✅ Limpieza de caché programada

## 🧪 Pruebas

### Ejecutar Pruebas Completas

```bash
php test_api_externa.php
```

### Verificar Funcionamiento

1. **Iniciar servidores**:
   ```bash
   php artisan serve
   npm run dev
   ```

2. **Probar en el navegador**:
   - http://127.0.0.1:8000/api-externa/propiedades
   - http://127.0.0.1:8000/api-externa/propiedad/1
   - http://127.0.0.1:8000/api-externa/mapa-propiedades

## 🔄 Cómo Activar la API Externa

Para reemplazar completamente las rutas originales:

1. **Opción 1: Modificar rutas existentes**
   ```php
   // En routes/public.php
   Route::get('/propiedades', [PropiedadPublicControllerWithApi::class, 'index']);
   Route::get('/propiedad/{id}', [PropiedadPublicControllerWithApi::class, 'show']);
   Route::get('/mapa-propiedades', [PropiedadPublicControllerWithApi::class, 'mapa']);
   ```

2. **Opción 2: Modificar el controlador original**
   - Reemplazar `PropertyFilterService` por `ExternalPropertyFilterService`
   - Actualizar las inyecciones de dependencia

## ⚠️ Limitaciones y Consideraciones

### Limitaciones Actuales

1. **Filtros**: La API externa no soporta filtros del lado del servidor, se aplican localmente
2. **Ubicación**: No hay datos de ubicación geográfica
3. **Performance**: Latencia adicional por llamadas HTTP
4. **Disponibilidad**: Depende de la disponibilidad de la API externa

### Mejoras Futuras

1. **Cache más inteligente**: Implementar cache por producto
2. **Fallback**: Mecanismo de fallback a base de datos local
3. **Indicador de estado**: Mostrar si la API está disponible
4. **Sincronización**: Opción de sincronizar datos localmente

## 🛡️ Manejo de Errores

El sistema incluye manejo de errores robusto:

- **Timeout**: 30 segundos por defecto
- **Fallos de autenticación**: Error 401 si la API Key es inválida o está ausente
- **Fallos de API**: Mensaje de error amigable al usuario
- **Datos inválidos**: Validación y formateo seguro
- **Fallback**: Opción de mostrar mensaje de error personalizado

### Errores Comunes

| Código HTTP | Descripción | Solución |
|-------------|-------------|----------|
| 401 | API Key requerida o inválida | Verificar que `EXTERNAL_API_KEY` esté configurada correctamente en `.env` |
| 403 | API Key sin permisos | Contactar al administrador de la API externa |
| 404 | Recurso no encontrado | Verificar que el ID del producto exista |
| 500 | Error interno del servidor | Reintentar más tarde o contactar soporte |
| 503 | Servicio no disponible | La API externa está temporalmente fuera de servicio |

## 📝 Notas de Desarrollo

### Cache Strategy

- **Duración**: 5 minutos por defecto
- **Claves**: Únicas por combinación de filtros
- **Limpieza**: Manual o programada

### Performance

- **Lazy Loading**: Solo se carga cuando se necesita
- **Batch Requests**: Agrupación de peticiones cuando es posible
- **Compression**: Respuestas JSON comprimidas

### Seguridad

- **Input Validation**: Todos los parámetros son validados
- **Output Sanitization**: Los datos de la API son limpiados
- **Error Handling**: No se expone información sensible

## 🚀 Despliegue

Para despliegue en producción:

1. **Variables de entorno**: Configurar URL correcta de la API
2. **Cache**: Considerar mayor duración (15-30 minutos)
3. **Monitoreo**: Implementar monitoreo de disponibilidad
4. **Backup**: Tener un plan de contingencia si la API falla

---

**Estado**: ✅ Completado y probado
**Última actualización**: 17/12/2025
**Versión**: 1.0