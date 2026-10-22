export type UpdateRiskType = {
    description: string|null;
    notifiable: boolean;
    max_delay_limit_in_minutes: number;
    max_size_loss_in_percent: number;
};
