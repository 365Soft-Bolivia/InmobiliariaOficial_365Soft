/**
 * Composable para manejar URLs de imágenes de forma inteligente
 * Soporta URLs externas (http/https) y locales (rutas relativas)
 */
export function useImageUrl() {
    /**
     * Obtiene la URL completa de una imagen
     * @param imagePath - Ruta de la imagen (puede ser URL completa o relativa)
     * @returns URL completa de la imagen
     */
    const getImageUrl = (imagePath: string | null | undefined): string => {
        // Si no hay imagen, retornar placeholder
        if (!imagePath) {
            return getPlaceholderImage();
        }

        // Si ya es una URL completa (http/https), retornarla tal cual
        if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
            return imagePath;
        }

        // Si es una ruta relativa, agregar el prefijo /storage/
        return `/storage/${imagePath}`;
    };

    /**
     * Genera una imagen placeholder cuando no hay imagen disponible
     * @returns SVG data URI con placeholder
     */
    const getPlaceholderImage = (): string => {
        return 'data:image/svg+xml,%3Csvg width="400" height="300" xmlns="http://www.w3.org/2000/svg"%3E%3Crect width="400" height="300" fill="%23f3f4f6"/%3E%3Cg fill="%239ca3af"%3E%3Crect x="150" y="100" width="100" height="80" rx="4"/%3E%3Crect x="120" y="190" width="40" height="30" rx="2"/%3E%3Crect x="170" y="190" width="40" height="30" rx="2"/%3E%3Crect x="220" y="190" width="40" height="30" rx="2"/%3E%3Cpolygon points="200,60 220,100 180,100"/%3E%3C/g%3E%3Ctext x="200" y="250" text-anchor="middle" fill="%236b7280" font-family="Arial" font-size="14"%3ESin imagen%3C/text%3E%3C/svg%3E';
    };

    /**
     * Verifica si una URL es externa
     * @param url - URL a verificar
     * @returns true si la URL es externa
     */
    const isExternalUrl = (url: string): boolean => {
        return url.startsWith('http://') || url.startsWith('https://');
    };

    /**
     * Obtiene el nombre del archivo de una URL
     * @param url - URL de la imagen
     * @returns Nombre del archivo
     */
    const getFileName = (url: string): string => {
        if (isExternalUrl(url)) {
            return url.split('/').pop() || 'imagen';
        }
        return url.split('/').pop() || 'imagen';
    };

    return {
        getImageUrl,
        getPlaceholderImage,
        isExternalUrl,
        getFileName
    };
}
