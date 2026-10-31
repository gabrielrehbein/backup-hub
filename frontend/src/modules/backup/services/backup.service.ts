import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { BackupType } from "../types/backup-type";

export class BackupService extends BaseBackupHubApiService {

    public async getLastBackupByInstence(): Promise<BackupType> {
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
