import { BaseBackupHubApiService } from "@/src/utils/api/base-backup-hub-api-service";
import { PlanType } from "../types/plan-type";
import { CreatePlanDto } from "../dtos/create-plan-dto";


export class PlanService extends BaseBackupHubApiService {
    public async createPlan(plan: CreatePlanDto): Promise<PlanType> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/plans`, {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
                },
                body: plan.toJson(),
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

    public async getPlans(): Promise<Array<PlanType>> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/plans`, {
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

    public async getPlanById(id: string): Promise<PlanType> {
        try {
            const response = await fetch(`${this.getBaseUrl()}/plans/${id}`, {
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
