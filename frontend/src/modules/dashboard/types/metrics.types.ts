export interface DashboardSummary {
    total_clients: number;
    total_backups: number;
    risk_backups: number;
}

export type RiskType = "TIME" | "SIZE";

export type SizeUnit = "KB" | "MB" | "GB" | "TB";

export interface RiskMetric {
    name: string;
    level: number;
    quantity: number;
}

export interface RiskByType {
    type: RiskType;
    quantity: number;
}
export type BackupsGeneratedToday = {
    byHour: Array<{hour: number, quantity: number}>;
    total: number;
};
export interface Backup {
    client_name: string;
    system_name: string;
    generated_at: Date;
    size: number;
    size_type: SizeUnit;
    risk: number;
    source_ip: string;
    file_path: string;
    is_local: boolean;
}

export interface RecentBackups {
    local: Backup[];
    remote: Backup[];
}

export interface ClientRisk {
    clientName: string;
    riskQuantity: number;
}

export interface ClientsWithMostBackupRiskByPlan {
    planName: string;
    clients: ClientRisk[];
}

export interface Dashboard {
    summary: DashboardSummary;

    riskDistribution: RiskMetric[];

    riskByType: RiskByType[];

    recentBackups: RecentBackups;

    clientsWithMostBackupRiskByPlan: ClientsWithMostBackupRiskByPlan[];
    
    backupsGeneratedToday: BackupsGeneratedToday;

}