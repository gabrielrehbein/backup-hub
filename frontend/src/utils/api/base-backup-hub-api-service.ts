export abstract class BaseBackupHubApiService {

    protected getBaseUrl(): string {
        const isServer = typeof window === "undefined";
        const url = isServer
            ? process.env.SERVER_BACKUP_HUB_API_BASE_URL
            : process.env.NEXT_PUBLIC_BACKUP_HUB_API_BASE_URL;
    
        if (!url) {
            console.error(
                `[API] URL base não configurada. IsServer: ${isServer}. ` +
                `Verifique as variáveis de ambiente SERVER_BACKUP_HUB_API_BASE_URL e NEXT_PUBLIC_BACKUP_HUB_API_BASE_URL.`
            );
            return "http://localhost:8000/api"; 
        }
    
        return url.endsWith("/") ? url.slice(0, -1) : url;
    }

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    protected getMessageError(errorData: any, response?: Response): string {
        const firstValidationError = Object.values(errorData?.errors ?? {})[0] as string[] | undefined;
        return firstValidationError?.[0]
            ?? errorData?.message
            ?? response?.statusText
            ?? "Erro inesperado ao comunicar com a API";
    }
}
