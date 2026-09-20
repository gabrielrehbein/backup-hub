export abstract class BaseBackupHubApiService {

    protected getBaseUrl(): string {
        return typeof window === "undefined" ?
        process.env.SERVER_BACKUP_HUB_API_BASE_URL! :
        process.env.NEXT_PUBLIC_BACKUP_HUB_API_BASE_URL!
    }
}
