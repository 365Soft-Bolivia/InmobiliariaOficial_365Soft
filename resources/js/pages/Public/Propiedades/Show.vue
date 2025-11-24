<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';

interface Props {
    propiedad: any;
    relacionadas: any[];
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
                {{ propiedad.titulo }}
            </h1>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                <p class="text-gray-600 dark:text-gray-400">
                    Detalles de la propiedad próximamente...
                </p>
            </div>
        </div>
    </div>
</template>