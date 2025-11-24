// Rutas personalizadas que no se sobrescriben con wayfinder:generate
// Este directorio está separado para evitar ser eliminado por wayfinder
import type { RouteDefinition } from './../wayfinder';

// Importar rutas generadas por wayfinder
import * as generatedRoutes from './../routes/index';

// Importar rutas admin específicas (estas ya existen con el prefijo /admin)
import adminRoutes from './../routes/admin/index';

// Usar las rutas existentes generadas por wayfinder para el admin
export const admin = adminRoutes;

// Exportar rutas públicas para acceso fácil
export const publicRoutes = {
  home: generatedRoutes.home,
};

// Reexportar rutas generadas si necesitas acceder a ellas
export { generatedRoutes };

// Tipos para las rutas personalizadas
export type CustomRouteDefinition = RouteDefinition & {
  url: string;
  method: 'get' | 'post' | 'put' | 'delete' | 'patch';
};