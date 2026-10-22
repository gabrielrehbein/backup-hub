import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { RiskType } from "../types/risk-type";
import { UpdateRiskType } from "../types/update-risk-type";


export class RiskService extends BaseBackupHubApiService {

    public async getRisks(): Promise<RiskType[]> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/risks`, {
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
    public async getRiskById(id: string): Promise<RiskType> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/risks/${id}`, {
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

    public async updateRisk(id: string, risk: UpdateRiskType): Promise<RiskType> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/risks/${id}`, {
                method: "PATCH",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
                },
                body: JSON.stringify(risk),
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
