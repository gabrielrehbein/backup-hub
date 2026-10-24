import { RiskType } from "../../risk/types/risk-type";

export type BackupRiskType = {
    id: number;
    backup_id: number;
    type: string;
    risk: RiskType;
    description: string;
    is_active: boolean;
    delay_in_minutes: number;
    size_loss_percent: number;
    created_at: string;
    updated_at: string;
};