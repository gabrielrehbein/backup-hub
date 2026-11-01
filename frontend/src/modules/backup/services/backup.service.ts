import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { FilterLastBackupByInstanceDTO } from "../dtos/filter-backup-by-instance-dto";
import { BackupType, SizeType } from "../types/backup-type";
import { PaginetedBackupType } from "../types/paginated-backup-type";


export class BackupService extends BaseBackupHubApiService {
    public async getAllBackups(): Promise<PaginetedBackupType>{
        const response = await fetch(`${this.getBaseUrl()}/backups`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                "Accept": "application/json",
            },
        })
        if(!response.ok){
            const errorData = await response.json();
            throw new Error(this.getMessageError(errorData, response));
        }

        const data = await response.json();
        console.log(data)
        return data.data;
    }

    public async getLastBackupByInstance(
        filters: FilterLastBackupByInstanceDTO = new FilterLastBackupByInstanceDTO(),
        returnInSizeType: SizeType = "mb"
    ): Promise<BackupType[]> {
        const params = filters.toQueryParams();
        params.append("return_in_size_type", returnInSizeType);

        const response = await fetch(`${this.getBaseUrl()}/backups/instances/latest?${params.toString()}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                "Accept": "application/json",
            },
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(this.getMessageError(errorData, response));
        }

        const data = await response.json();
        return data.data;
    }
}
