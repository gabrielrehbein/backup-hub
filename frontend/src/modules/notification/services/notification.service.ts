import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";

export class NotificationService extends BaseBackupHubApiService {

    public async getNotificationConfig() {
        const response = await fetch(`${this.getBaseUrl()}/notifications/config`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Config notify response:', data.data);
        return data;
    }

    public async saveNotificationConfig(payload: { email: string }) {
        const response = await fetch(`${this.getBaseUrl()}/notifications/config`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
            body: JSON.stringify(payload),
        });
        const data = await response.json();
        return data;
    }
}