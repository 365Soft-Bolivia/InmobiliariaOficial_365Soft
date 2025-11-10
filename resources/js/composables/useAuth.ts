// composables/useAuth.ts
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { PageProps, UserRole } from '@/types';

interface AuthPageProps extends PageProps {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
            roles: UserRole[];
        } | null;
    };
}

export function useAuth() {
    const page = usePage<AuthPageProps>();
    const user = computed(() => page.props.auth.user);

    /**
     * Verifica si el usuario está autenticado
     */
    const isAuthenticated = computed(() => !!user.value);

    /**
     * Verifica si el usuario tiene un rol específico
     */
    const hasRole = (roleName: string): boolean => {
        if (!user.value?.roles || user.value.roles.length === 0) return false;
        return user.value.roles.some(role => role.name === roleName);
    };

    /**
     * Verifica si el usuario tiene alguno de los roles especificados
     */
    const hasAnyRole = (roles: string[]): boolean => {
        if (!roles || roles.length === 0) return true;
        if (!user.value?.roles || user.value.roles.length === 0) return false;
        return user.value.roles.some(role => roles.includes(role.name));
    };

    /**
     * Verifica si el usuario tiene todos los roles especificados
     */
    const hasAllRoles = (roles: string[]): boolean => {
        if (!roles || roles.length === 0) return true;
        if (!user.value?.roles || user.value.roles.length === 0) return false;
        
        const userRoleNames = user.value.roles.map(role => role.name);
        return roles.every(requiredRole => userRoleNames.includes(requiredRole));
    };

    /**
     * Verifica si el usuario es admin
     */
    const isAdmin = computed(() => hasRole('admin'));

    /**
     * Obtiene el nombre del primer rol (para compatibilidad)
     */
    const currentRole = computed(() => user.value?.roles?.[0]?.name || null);

    /**
     * Obtiene el primer rol (para compatibilidad)
     */
    const role = computed(() => user.value?.roles?.[0] || null);

    /**
     * Obtiene todos los roles
     */
    const roles = computed(() => user.value?.roles || []);

    return {
        user,
        role,        // Para compatibilidad (primer rol)
        roles,       // Todos los roles
        isAuthenticated,
        hasRole,
        hasAnyRole,
        hasAllRoles,
        isAdmin,
        currentRole, // Para compatibilidad
    };
}