import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";

export class InstanceService extends BaseBackupHubApiService {

    public async getInstances() {

        const response = await fetch(`${this.getBaseUrl()}/instances`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Intances response:', data.data);
        return data;
    }

    public async refreshApiKey(id: string) {
        const response = await fetch(`${this.getBaseUrl()}/instances/${id}/api-key/refresh`, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Intances response:', data.data);
        return data;
    }

    public async getIntanceById(id: string) {
        const response = await fetch(`${this.getBaseUrl()}/instances/${id}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            }
        });
        const data = await response.json();
        console.log("GET INSTANCIA POR ID: ", data.data);
        return data;
    }
}