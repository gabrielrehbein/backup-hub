import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { BackupRiskType } from "../types/backup-risk-type";

export class BackupRiskService extends BaseBackupHubApiService {
    public async getRisksByBackupId(backupId: number): Promise<Array<BackupRiskType>> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/backup-risks/backup/${backupId}`, {
                method: "GET",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
                },
            });
            if (!response.ok) {
                const errorData = await response.json();
                const message = this.getMessageError(errorData);
                throw new Error(message);
            }
            const data = await response.json();
            console.log("BackupRiskService.getRisksByBackupId - data:", data);
            return data.data;
        } catch (error) {
            throw error;
        }
    }

    public async getLastBackupByInstence() {
        try {
            const response = await fetch("http://localhost:8000/api/backups/instances/latest?return_in_size_type=mb", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    "Accept": "application/json",
                },
            });
            if (!response.ok) {
                const errorData = await response.json();
                const message = this.getMessageError(errorData);
                throw new Error(message);
            }

            const data = await response.json();
            console.log("BackupRiskService.getLastBackupByInstence - data:", data);
            return data.data;
        } catch (error) {
            throw error;
        }
    };
}
