import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { PublicUserType } from "../types/public-user-type";
import { CreateUserType } from "../types/create-user-type";

export class UserService extends BaseBackupHubApiService {

    public async getUsers(): Promise<Array<PublicUserType>> {

        const response = await fetch(`${this.getBaseUrl()}/users`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Users response:', data.data);
        return data.data;
    }

    public async createUser(user: CreateUserType): Promise<PublicUserType> {
        const response = await fetch(`${this.getBaseUrl()}/users`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
            body: JSON.stringify(user),
        });
        const data = await response.json();
        return data.data;
    }
}
