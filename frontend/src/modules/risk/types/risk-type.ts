export type RiskType = {
    id: string;
    name: string;
    description: string|null;
    level: number;
    notifiable: boolean;
    max_delay_limit_in_minutes: number;
    max_size_loss_in_percent: number;
    plan_id: string;
    createda_at: string;
    updated_at: string;
};
