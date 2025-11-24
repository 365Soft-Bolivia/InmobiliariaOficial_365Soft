<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Props {
    propiedades: any[];
    filtros: any;
}

defineProps<Props>();

defineOptions({
    layout: PublicLayout
});
</script>

<template>
    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold mb-8 text-gray-900 dark:text-white">
                Todas las Propiedades
            </h1>

            <!-- Filtros (placeholder) -->
            <div class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                <p class="text-gray-600 dark:text-gray-400">
                    Filtros disponibles próximamente...
                </p>
            </div>

            <!-- Grid de propiedades -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="text-center text-gray-500 dark:text-gray-400 col-span-full">
                    <p>No hay propiedades disponibles aún.</p>
                </div>
            </div>
        </div>
    </div>
</template>