<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import PublicHeader from '@/components/public/PublicHeader.vue';
import PublicFooter from '@/components/public/PublicFooter.vue';

interface Props {
    title?: string;
}

withDefaults(defineProps<Props>(), {
    title: 'Inmobiliaria'
});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <PublicHeader />

        <!-- Contenido principal -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <PublicFooter />
    </div>
</template>