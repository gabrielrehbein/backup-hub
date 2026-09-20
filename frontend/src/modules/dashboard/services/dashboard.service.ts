import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";

export class DashboardService extends BaseBackupHubApiService {

    public async getMetrics() {
        const sizeType = "mb";

        const response = await fetch(`${this.getBaseUrl()}/dashboard/metrics?return_in_size_type=${sizeType}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Dashboard metrics response:', data.data);
        return data;
    }
}