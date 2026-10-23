import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { ClientType } from "../types/client-type";


export class ClientService extends BaseBackupHubApiService {
    public async getClients(): Promise<Array<ClientType>> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/clients`, {
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
            return data.data;
        } catch (error) {
            throw error;
        }
    }

}
