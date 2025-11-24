<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Props {
    featured_properties: any[];
    stats: {
        total_propiedades: number;
        ciudades: number;
        clientes_satisfechos: number;
    };
}

defineProps<Props>();

defineOptions({
    layout: PublicLayout
});
</script>

<template>
    <div>
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Encuentra tu hogar ideal
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Las mejores propiedades en Bolivia
                </p>
                
                   <!-- <a :href="route('public.propiedades')"
                    class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors"
                > -->
                    <!-- Ver Propiedades -->
                   <!-- </a> -->
                
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">{{ stats.total_propiedades }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Propiedades</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">{{ stats.ciudades }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Ciudades</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">{{ stats.clientes_satisfechos }}+</div>
                        <div class="text-gray-600 dark:text-gray-400">Clientes Satisfechos</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Propiedades Destacadas (placeholder por ahora) -->
        <section class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    Propiedades Destacadas
                </h2>
                <div class="text-center text-gray-500 dark:text-gray-400">
                    <!-- Aquí irán las propiedades destacadas -->
                    <p>Próximamente...</p>
                </div>
            </div>
        </section>
    </div>
</template>