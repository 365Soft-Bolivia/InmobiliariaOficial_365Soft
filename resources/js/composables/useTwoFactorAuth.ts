import twoFactor from '@/routes/admin/two-factor';
import { computed, ref } from 'vue';

const fetchJson = async <T>(url: string): Promise<T> => {
    const response = await fetch(url, {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        throw new Error(`Failed to fetch: ${response.status}`);
    }

    return response.json();
};

const errors = ref<string[]>([]);
const manualSetupKey = ref<string | null>(null);
const qrCodeSvg = ref<string | null>(null);
const recoveryCodesList = ref<string[]>([]);

const hasSetupData = computed<boolean>(
    () => qrCodeSvg.value !== null && manualSetupKey.value !== null,
);

export const useTwoFactorAuth = () => {
    // Nota: Las rutas qrCode, recoveryCodes y secretKey no están definidas
    // en el proyecto actual. Estas funciones se dejan como placeholders
    // para futura implementación.

    const fetchQrCode = async (): Promise<void> => {
        try {
            // TODO: Implementar cuando la ruta esté disponible
            // const { svg } = await fetchJson<{ svg: string; url: string }>(
            //     qrCode.url(),
            // );
            // qrCodeSvg.value = svg;
            console.warn('fetchQrCode: ruta no implementada');
        } catch {
            errors.value.push('Failed to fetch QR code');
            qrCodeSvg.value = null;
        }
    };

    const fetchSetupKey = async (): Promise<void> => {
        try {
            // TODO: Implementar cuando la ruta esté disponible
            // const { secretKey: key } = await fetchJson<{ secretKey: string }>(
            //     secretKey.url(),
            // );
            // manualSetupKey.value = key;
            console.warn('fetchSetupKey: ruta no implementada');
        } catch {
            errors.value.push('Failed to fetch a setup key');
            manualSetupKey.value = null;
        }
    };

    const clearSetupData = (): void => {
        manualSetupKey.value = null;
        qrCodeSvg.value = null;
        clearErrors();
    };

    const clearErrors = (): void => {
        errors.value = [];
    };

    const clearTwoFactorAuthData = (): void => {
        clearSetupData();
        clearErrors();
        recoveryCodesList.value = [];
    };

    const fetchRecoveryCodes = async (): Promise<void> => {
        try {
            // TODO: Implementar cuando la ruta esté disponible
            // clearErrors();
            // recoveryCodesList.value = await fetchJson<string[]>(
            //     recoveryCodes.url(),
            // );
            console.warn('fetchRecoveryCodes: ruta no implementada');
        } catch {
            errors.value.push('Failed to fetch recovery codes');
            recoveryCodesList.value = [];
        }
    };

    const fetchSetupData = async (): Promise<void> => {
        try {
            clearErrors();
            await Promise.all([fetchQrCode(), fetchSetupKey()]);
        } catch {
            qrCodeSvg.value = null;
            manualSetupKey.value = null;
        }
    };

    return {
        twoFactor,
        qrCodeSvg,
        manualSetupKey,
        recoveryCodesList,
        errors,
        hasSetupData,
        clearSetupData,
        clearErrors,
        clearTwoFactorAuthData,
        fetchQrCode,
        fetchSetupKey,
        fetchSetupData,
        fetchRecoveryCodes,
    };
};
