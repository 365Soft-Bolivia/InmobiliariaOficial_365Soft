<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import twoFactor from '@/routes/admin/two-factor';
// import { disable, enable } from '@/routes/admin/two-factor'; // TODO: Rutas no implementadas
import { BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';

interface Props {
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
}

withDefaults(defineProps<Props>(), {
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Autenticacion de dos factores',
        href: twoFactor.show.url(),
    },
];

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => {
    clearTwoFactorAuthData();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Autenticacion de dos factores" />
        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall
                    title="Autenticacion de dos factores"
                    description="Administre su configuración de autenticación de dos factores"
                />

                <div
                    v-if="!twoFactorEnabled"
                    class="flex flex-col items-start justify-start space-y-4"
                >
                    <Badge variant="destructive">Deshabilitado</Badge>

                    <p class="text-muted-foreground">
                        Cuando se habilita la autenticación de dos factores, se
                        solicitara un PIN durante el inicio de sesión. Este pin puede ser
                        recuperado de una aplicación respaldada por TOTP en su
                        teléfono.
                    </p>

                    <div>
                        <Button
                            v-if="hasSetupData"
                            @click="showSetupModal = true"
                        >
                            <ShieldCheck />Continuar configuración
                        </Button>
                        <!-- TODO: enable.form() no implementado -->
                        <Button
                            v-else
                            @click="showSetupModal = true"
                        >
                            <ShieldCheck />Habilitar 2FA (Demo)</Button
                        >
                    </div>
                </div>

                <div
                    v-else
                    class="flex flex-col items-start justify-start space-y-4"
                >
                    <Badge variant="default">Habilitado</Badge>

                    <p class="text-muted-foreground">
                        Cuando se habilita la autenticación de dos factores, se
                        solicitara un PIN durante el inicio de sesión. Este pin puede ser
                        recuperado de una aplicación respaldada por TOTP en su
                        teléfono.
                    </p>

                    <TwoFactorRecoveryCodes />

                    <div class="relative inline">
                        <!-- TODO: disable.form() no implementado -->
                        <Button
                            variant="destructive"
                            disabled
                        >
                            <ShieldBan />
                            Deshabilitar 2FA (No disponible)
                        </Button>
                    </div>
                </div>

                <TwoFactorSetupModal
                    v-model:isOpen="showSetupModal"
                    :requiresConfirmation="requiresConfirmation"
                    :twoFactorEnabled="twoFactorEnabled"
                />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
