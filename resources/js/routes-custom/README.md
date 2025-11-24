# Rutas Personalizadas del Sistema Inmobiliario

## 📁 Estructura de Archivos

- `../routes/` - Directorio gestionado por `wayfinder:generate`
- `index.ts` - Archivo seguro de rutas personalizadas (no se sobrescribe)

## 🚨 Comandos Importantes

```bash
# Generar rutas automáticamente (esto no afecta este directorio)
php artisan wayfinder:generate

# Iniciar servidor de desarrollo
npm run dev
```

## 🔗 Importación de Rutas

En los componentes de Vue, usar siempre:

```typescript
import { admin } from '@/routes-custom';
```

## 🛡️ Rutas Administrativas

Todas las rutas de admin tienen el prefijo `/admin`:
- Dashboard: `/admin/dashboard`
- Proyectos: `/admin/proyectos`
- Ubicaciones: `/admin/ubicaciones`
- Categorías: `/admin/categorias`
- Accesos: `/admin/accesos`
- Roles: `/admin/roles`

## 🌐 Rutas Públicas

- Home: `/`
- Propiedades: `/propiedad/{id}`

## ⚠️ Advertencia Importante

- **NUNCA** edites manualmente los archivos en `../routes/` ya que se sobrescriben automáticamente
- Este directorio `routes-custom/` está protegido y no será afectado por `wayfinder:generate`
- Para agregar nuevas rutas personalizadas, modifica este archivo `index.ts`