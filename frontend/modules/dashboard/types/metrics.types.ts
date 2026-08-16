export interface DashboardSummary {
    total_clients: number;
    total_backups: number;
    risk_backups: number;
    backups_generated_today: number;
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
    clientName: string;
    generatedAt: Date;
    fileSize: number;
    sizeUnit: SizeUnit;
    ipSource: string;
    filePath: string;
    isLocal: boolean;
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